<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	die(header("Location: login.php"));
}
?>
<?php

if (isset($_POST["save"])) {
	$current_password = se($_POST, "currentPassword", null, false);
	$new_password = se($_POST, "newPassword", null, false);
	$confirm_password = se($_POST, "confirmPassword", null, false);
	$db = getDB();

	if (isset($current_password) && isset($new_password) && isset($confirm_password)) {
		if ($new_password === $confirm_password) {
			$stmt = $db->prepare("SELECT password from Users where id = :id");
			try {
				$stmt->execute([":id" => get_user_id()]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($result["password"])) {
					if (password_verify($current_password, $result["password"])) {
						$query = "UPDATE Users SET password = :password where id = :id";
						$stmt = $db->prepare($query);
						$stmt->execute([":id" => get_user_id(), ":password" => password_hash($new_password, PASSWORD_BCRYPT)]);
						flash("Password successfully reset!", "bg-green-200");
					} else {
						flash("Current Password is invalid!", "bg-red-200");
					}
				}
			} catch (Exception $e) {
				flash("Something went wrong...", "bg-red-200");
				echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
			}
		}
	}
}

?>



<?php
// For the form
$email = get_user_email();
$username = get_username();
?>
<div class="w-1/2 mx-auto p-4 mt-4">
	<div class="my-8 space-y-2 bg-yellow-300 rounded p-4">
		<h1 class="text-xl">Reset Password</h1>
		<p>Password must contain atleast: 8 characters, 1 digit, 1 special character, 1 Uppercase character</p>
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
		<!-- DO NOT PRELOAD PASSWORD -->
		<hr class="my-8" />
		<div class="pt-3">
			<div class="mb-3">
				<label for="cp">Current Password</label>
				<input type="password" name="currentPassword" id="cp" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
			</div>
			<div class="mb-3">
				<label for="np">New Password</label>
				<input type="password" name="newPassword" id="np" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
			</div>
			<div class="mb-3">
				<label for="conp">Confirm Password</label>
				<input type="password" name="confirmPassword" id="conp" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
			</div>
			<div>
				<button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" value="save" name="save">
					<span class="absolute left-0 inset-y-0 flex items-center pl-3">
						<!-- Heroicon name: solid/lock-closed -->
						<svg class="h-5 w-5 text-gray-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
						</svg>
					</span>
					Reset Password
				</button>
			</div>
	</form>
</div>

<script>
	// Do password validation
	function validate(form) {
		const new_password = form.newPassword.value;
		const confirm_password = form.confirmPassword.value;
		const errors = validatePassword(new_password, confirm_password);
		
		if (errors.length > 0) {
			errors.map((error) => {
				flash(error, "bg-red-200");
			})
			return false;
		} else {
			return true;
		}
	}
</script>

<?php
//note we need to go up 1 more directory
require_once(__DIR__ . "/../../../partials/flash.php");
?>