function flash(message = "", color = "info", speed = 1000, type = "")
{
    let flash = document.getElementById("flash");
    //create a div (or whatever wrapper we want)
    let outerDiv = document.createElement("div");
    outerDiv.className = "row justify-content-center p-4 " + color + " rounded my-4 relative";
    let innerDiv = document.createElement("div");

    //apply the CSS (these are bootstrap classes which we'll learn later)
    innerDiv.className = `alert alert-${ color }`;
    //set the content
    innerDiv.innerText = message;

    outerDiv.appendChild(innerDiv);
    //add the element to the DOM (if we don't it merely exists in memory)
    flash.appendChild(outerDiv);

    if (type == "fade")
    {
        fadeOut(outerDiv, speed);
        if (outerDiv.classList.contains("opacity-0")) outerDiv.remove();
    }

}

function fadeOut(element, speed)
{
    const fadeTime = speed / 1000;
    element.style.transition = "opacity " + fadeTime + "s ease";

    // Got logic from https://javascript.info/settimeout-setinterval
    const isDoneId = setInterval(() =>
    {
        element.classList.add("opacity-0");
        setTimeout(() =>
        {
            clearInterval(isDoneId);
            element.remove();
        }, speed)
    }, 2000)
}

function change_cart_counter(message)
{
    const cart = document.getElementById("cart-count");
    cart.innerText = message.count
}
function add_to_cart(e)
{
    const product_id = e.id
    $.post("./cart/add_to_cart.php", {
        product_id: product_id
    }, (res) =>
    {
        const data = JSON.parse(res);
        const { message, status } = data
        if (status === 200)
        {
            get_cart_count();
            window.scrollTo(0, 0);
            flash(message, "bg-green-200", 1000, "fade");
        }
    })
}

function get_cart_count()
{
    $.get("./products/get_cart_count.php", (res) =>
    {
        let data = JSON.parse(res);
        const { message, status, logged_in } = data
        if (logged_in)
        {
            if (status === 200)
            {
                change_cart_counter(message);
            }
            else
            {
                flash(message, "bg-red-200", 1000, "fade");
            }
        }
    })
}


function update_qty(cart_id, stock)
{
    // Get cart ID form
    const cartID = cart_id;
    const new_qty = $("#quantity").val();
    $.post('./cart/view_cart.php', {
        type: "update_qty",
        quantity: new_qty,
        cart: cartID,
        stock: stock
    }, () =>
    {
        location.reload();
    })

}

function remove_item(cart_id)
{
    const cartID = cart_id;
    $.post('./cart/view_cart.php', {
        cart: cartID,
        type: 'delete_item',
    }, (data) =>
    {
        location.reload();
    })
}

function remove_all_items()
{
    $.post('./cart/view_cart.php', {
        type: 'delete_all'
    }, (data) =>
    {
        location.reload();
    })

}
function add_new_product(event, type)
{
    event.preventDefault();
    const spinner = document.getElementById("spinner");
    const name = document.getElementById("product_name").value;
    const desc = document.getElementById("product_description").value;
    const cost = document.getElementById("product_cost").value;
    const stock = document.getElementById("product_stock").value;
    const category = get_category();
    const visibility = get_visibility();

    if (type == "add_product")
    {

        let imageURL = upload_image(event);
        imageURL = imageURL.then(res =>
        {
            res.ref.getDownloadURL().then((downloadURL) =>
            {
                spinner.classList.remove('invisible');
                $.post(`./../api/${ type }.php`, {
                    name: name,
                    desc: desc,
                    cost: cost,
                    stock: stock,
                    category: category,
                    visibility: visibility,
                    imageURL: downloadURL
                }, (data, status) =>        
                {
                    location.reload();
                })
            })
        })
    } else if (type == "edit_product")
    {
        const product_id = document.getElementById("product_id").value;
        $.post(`./../api/${ type }.php`, {
            name: name,
            desc: desc,
            cost: cost,
            stock: stock,
            category: category,
            visibility: visibility,
            product_id: product_id
        }, (data, status) =>        
        {
            location.reload();
        })
    }
}

function get_visibility()
{
    let visibility = document.getElementById("product_visiblity").checked;
    console.log(visibility);
    return visibility;
}

function get_category()
{
    const category = document.getElementById("product_category");
    return category.value;
}


function upload_image(e)
{
    let files = e.target.product_image.files;

    if (files.length > 0)
    {
        let file = files[0];
        let task = storage.ref().child("images/" + file.name).put(file);
        return task;
    }

}



function checkout()
{
    const fName = document.getElementById("fName").value;
    const lName = document.getElementById("lName").value;
    const address = document.getElementById("address").value;
    const total = document.getElementById("total").value;
    const paymentMethod = getPaymentMethod();
    const zipcode = document.getElementById("zipcode").value;
    const payment = document.getElementById("payment").value
    const apt = document.getElementById("apt").value
    const state = getState();
    const isValid = validateCheckout(fName, lName, zipcode, payment, total, apt, address);

    if (isValid.length <= 0)
    {
        $.ajax({
            type: "POST",
            url: "../api/checkout.php",
            data: {
                type: "checkout",
                fName: fName,
                lName: lName,
                address: `${ address }, ${ apt }`,
                total: total,
                paymentMethod: paymentMethod,
                state: state,
                zipcode: zipcode
            },
            beforeSend: () => {
               const loading =  document.getElementById("loading");
               loading.classList.remove("hidden");
            }
        }).done((jsonRes) =>
        {
            const loading = document.getElementById("loading");
            loading.classList.add("hidden");
            document.getElementById("fName").value = ""
            document.getElementById("lName").value = ""
            document.getElementById("address").value = ""
            const message = JSON.parse(jsonRes);
            if (message.order_id < 0)
            {
                for (let i = 0; i < (message.message).length; i++)
                {
                    flash(message.message[i], "bg-red-200", 1000, "");
                }
                document.getElementById("fName").value = ""
                document.getElementById("lName").value = ""
                document.getElementById("address").value = ""
            } else
            {
                location.assign(`../cart/order_confirmation.php?order_id=${ message.order_id }`)
            }
        })
    } else
    {
        isValid.map((error) =>
        {
            document.getElementById("fName").value = ""
            document.getElementById("lName").value = ""
            document.getElementById("address").value = ""
            flash(error, "bg-red-200", 1000, "fade");
        })
    }

}

function getPaymentMethod()
{
    const category = document.getElementById("payment_method");
    return category.value;
}

function getState()
{
    const val = document.getElementById("state")
    return val.value;
}

function validateCheckout(fName, lName, zip, payment, total, apt, address)
{
    const regex = new RegExp('[0-9]+');
    const zipRegex = new RegExp("[0-9]{5}");
    let errors = [];
    if (regex.test(fName) || regex.test(lName))
    {
        errors.push("Name should not contain any number")
    }
    if (!zipRegex.test(zip) || zip.length > 5)
    {
        errors.push("Invalid Zip. (e.g 54321)");
    }
    if (payment !== total)
    {
        errors.push("Payment amount not does not match total: ", total);
    }
    return errors;
}
