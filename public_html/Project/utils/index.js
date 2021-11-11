
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




	// Menu items for collapsible nav
	const menuItems = [{
		label: "Edit Profile",
		path: "profile.php",
	},
	{
		label: "Reset Password",
		path: "account/reset_password.php"
	},
	{
		label: "View Profile",
		path: "account/view_profile.php"
	}
	]

	addItem(menuItems, ul);

	profileLink.addEventListener("click", (e) =>
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

// Add items to parent(should be a ul in this case)
function addItem(menu, parent)
{
	// Destructure label and path from links object
	menu.map(({ label, path }) =>
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


// Validation utility functions
function validatePassword(pw, cp)
{
	const pwRegEx = new RegExp(/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{8,})$/, 's');
	let errorMessage = [];

	if (!pwRegEx.test(pw) || !pwRegEx(cp))
	{
		debugger;
		errorMessage.push("Password must contain atleast: 8 characters, 1 digit, 1 special character, 1 Uppercase character");
	}

	if (pw !== cp)
	{
		debugger;
		errorMessage.push("Password must match");
	}

	return errorMessage;
}

function validateUser(email, uname)
{
	const unameRegEx = new RegExp('/^[a-z0-9_-]{3,30}$/i');
	let errorMessage = [];
	if (!unameRegEx.test(uname))
	{
		errorMessage.push("Username must only be alphanumeric and can only contain - or _");
	}
	return errorMessage;
}

function isEmail(email)
{
	return email.includes("@") ? true : false;
}