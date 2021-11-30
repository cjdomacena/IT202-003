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


function update_qty(cart_id)
{
    // Get cart ID form
    const cartID = cart_id;
    const new_qty = $("#quantity").val();
    $.post('./cart/view_cart.php', {
        type: "update_qty",
        quantity: new_qty,
        cart: cartID
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
function add_new_product(event)
{
    event.preventDefault();
    const spinner = document.getElementById("spinner");
    const name = document.getElementById("product_name").value;
    const desc = document.getElementById("product_description").value;
    const cost = document.getElementById("product_cost").value;
    const stock = document.getElementById("product_stock").value;
    const category = get_category();
    const visibility = get_visibility();
    let imageURL = upload_image(event);

    imageURL = imageURL.then(res =>
    {
        res.ref.getDownloadURL().then((downloadURL) =>
        {
            spinner.classList.remove('invisible');
            $.post('./../api/add_product.php', {
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







