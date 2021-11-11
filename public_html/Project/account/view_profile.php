<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	die(header("Location: login.php"));
}
?>




<?php
$email = get_user_email();
$username = get_username();
?>
<div class="w-1/2 mx-auto p-4 mt-4">
	<div class="my-4 space-y-4 p-4 bg-indigo-400 rounded text-white">
		<h1 class="text-xl ">View Profile</h1>
	</div>
	<form method="POST" onsubmit="return validate(this);">
		<div class="mb-3">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php se($email); ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" disabled />
		</div>
		<div class="mb-3">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?php se($username); ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" disabled />
		</div>
	</form>
</div>

<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>