
// Grab the <a> with id of profile-link
const profileLink = document.getElementById("profile-link");

// Grab collapsible-nav 
const collapse = document.getElementById("collapsible-nav");

// Create a ul element
// This will live inside the collapsible-nav
const ul = document.createElement("ul");

// Initialize the links that will be displayed in the collapsible-nav
const menuItems = ["Edit Email", "Edit Username", "Edit Password"];

// Loop through the menu items to create new <li> element
for (let i = 0; i < menuItems.length; i++)
{

	// Create new <li>
	const li = document.createElement("li");

	// Create new <a>
	// This will live inside the <li> element
	const link = document.createElement("a");

	// Create a new text node for the link
	link.appendChild(document.createTextNode(menuItems[i]));

	// Clean the initial menuItems (menuItems[i]) to be used as a href attribute
	const cleanedLink = menuItems[i].toLowerCase();

	// Will be split with an underscore(_)
	link.href = cleanedLink.split(" ").join("_");

	// Add the link inside the <li> element as its child
	li.appendChild(link);

	// Add classes
	li.classList.add("cursor-pointer");

	li.classList.add("hover:text-indigo-900");

	// Add the <li> that contains <a> as its child to the previously created <ul>
	ul.appendChild(li);
}

const li = document.createElement("li");

// Create new <a>
// This will live inside the <li> element
const link = document.createElement("a");

// Create a new text node for the link
link.appendChild(document.createTextNode("Profile"));
link.href = "./profile.php";
li.appendChild(link);

// Add classes
li.classList.add("cursor-pointer");

li.classList.add("hover:text-indigo-900");
ul.appendChild(li)

// Can be added later (based on preference)
// profileLink.addEventListener("mouseenter", () =>
// {
// 	collapse.classList.toggle("invisible");
// 	collapse.classList.toggle("visible");

// 	collapse.appendChild(ul);
// })

// Track user click events WITHIN the document
// This will allow simple functionality for the dropdown to be closed when user clicked outside of the "Profile" link to toggle the collapsed-nav.
document.addEventListener("click", (e) =>
{
	// If the profileLink is the same as the (e) that was given by the event listener
	if (!profileLink.contains(e.target))
	{

		// Remove the visible class
		collapse.classList.remove("visible");

		// Make the collapsible-nav invisible
		collapse.classList.add("invisible");

	} else
	{

		// Toggle between invisible and visible
		collapse.classList.toggle("invisible");
		collapse.classList.toggle("visible");

		collapse.appendChild(ul);
	}
})

// Just add styles to the <ul>
ul.classList.add("space-y-4");
ul.classList.add("text-indigo-600");
