
// IIFE
(function dropdown()
{
	// Grab the <a> with id of profile-link
	const profileLink = document.getElementById("profile-link");

	// Grab collapsible-nav 
	const collapse = document.getElementById("collapsible-nav");

	// Create a ul element
	// This will live inside the collapsible-nav
	const ul = document.createElement("ul");



	// Initialize the links that will be displayed in the collapsible-nav
	// const menuItems = ["Edit Email", "Edit Username", "Edit Password"];

	const menuItems = [{
		label: "Edit Profile",
		path: "profile.php",
	},
	{
		label: "Reset Password",
		path: "account/reset_password.php"
	}
	]

	addItem(menuItems, ul);

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
})();


// Track user click events WITHIN the document

// This will allow simple functionality for the dropdown to be closed when user clicked outside of the "Profile" link to toggle the collapsed-nav.

// JS version of get_url
function get_url_js(dest)
{
	BASE_PATH = "/Project/";
	if (dest[0] === "/")
	{
		return dest;
	}
	return BASE_PATH + dest;
}

function addItem(links, parent)
{
	// Destructure label and path
	links.map(({ label, path }) =>
	{
		const li = document.createElement("li");

		// This will live inside the <li> element
		const link = document.createElement("a");

		// Create a new text node for the link
		link.appendChild(document.createTextNode(label));
		if (path.includes("/\[a-zA-Z]$\/profile")) console.log(path);
		link.href = get_url_js(path);
		li.appendChild(link);

		// Add classes
		li.classList.add("cursor-pointer");

		li.classList.add("hover:text-indigo-900");
		parent.appendChild(li);
	})

	return parent;

}
