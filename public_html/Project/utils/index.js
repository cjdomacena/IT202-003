
// Validation utility functions
function validatePassword(pw, cp)
{
	const pwRegEx = new RegExp(/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{8,})$/, 's');
	let errorMessage = [];

	if (!pwRegEx.test(pw) || !pwRegEx(cp))
	{

		errorMessage.push("Password must contain atleast: 8 characters, 1 digit, 1 special character, 1 Uppercase character");
	}

	if (pw !== cp)
	{

		errorMessage.push("Password must match");
	}

	return errorMessage;
}

function validateUser(email, uname)
{
	const unameRegEx = new RegExp(/^[a-z0-9_-]{3,30}$/, 'i');
	let errorMessage = [];
	debugger;
	if (!unameRegEx.test(uname))
	{
		debugger;
		errorMessage.push("Username must only be alphanumeric and can only contain - or _");
	}
	if (uname.length < 3) 
	{
		errorMessage.push("Username must be 3 or more characters");
	}
	return errorMessage;
}

function isEmail(email)
{
	return email.includes("@") ? true : false;
}

