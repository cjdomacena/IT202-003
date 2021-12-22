<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
} else {
	$db = getDB();
	$uid = (int)get_user_id();
	$stmt = $db->prepare('SELECT visibility FROM Users WHERE id = :uid');
	try {
		$stmt->execute([':uid' => $uid]);
		$isVisible = $stmt->fetch();
	} catch (PDOException $e) {
		flash(var_export($e, true), "bg-red-200");
	}
}
?>

<?php
$email = get_user_email();
$username = get_username();
?>
<div class="container mx-auto p-4 mt-4 grid place-items-center space-y-4 mt-12">
	<div class="w-20 h-20 rounded-full bg-center bg-gray-100 bg-cover" style="background-image: url(https://ui-avatars.com/api/?name=<?php se($username) ?>&font-size=0.24&rounded=true&background=5850EC&color=fff&size=128);"></div>
	<div class="text-center space-y-1">
		<h1 class="capitalize"><?php se($username) ?></h1>
		<?php if ($isVisible['visibility']) : ?>
			<p><?php se($email) ?></p>
		<?php endif; ?>
		<?php if ($isVisible['visibility']) : ?>
			<p>Profile: Public</p>
		<?php else : ?>
			<p>Profile: Private</p>
		<?php endif; ?>
	</div>
	<div>
		<h2>Rated Products:</h2>
	</div>
</div>

<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>