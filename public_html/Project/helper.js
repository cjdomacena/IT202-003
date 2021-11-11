function flash(message = "", color = "info", speed = 1000, type = "")
{
    let flash = document.getElementById("flash");
    //create a div (or whatever wrapper we want)
    let outerDiv = document.createElement("div");
    outerDiv.className = "row justify-content-center p-4 " + color + " rounded my-4 relative";
    let innerDiv = document.createElement("div");

    //apply the CSS (these are bootstrap classes which we'll learn later)
    innerDiv.className = `alert alert-${color}`;
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

