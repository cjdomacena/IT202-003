<?php
require(__DIR__ . "/../../partials/nav.php");


if (isset($_GET['user'])) {
	$db = getDB();
	$uid =  se($_GET, 'user', -1, false);
	$stmt = $db->prepare('SELECT * FROM Users WHERE id = :uid');
	try {
		$stmt->execute([':uid' => $uid]);
		$user = $stmt->fetch();
	} catch (PDOException $e) {
		flash($e->errorInfo, 'bg-red-200');
	}
} else {
	redirect(get_url('index.php'));
}
?>

<div class="container mx-auto p-4 mt-4 grid place-items-center space-y-4 mt-12">
	<?php if (!empty($user)) : ?>
		<div class="w-20 h-20 rounded-full bg-center bg-gray-100 bg-cover" style="background-image: url(https://ui-avatars.com/api/?name=<?php se($user, 'username') ?>&font-size=0.24&rounded=true&background=5850EC&color=fff&size=128);"></div>
		<div class="text-center space-y-1">
			<h1 class="capitalize"><?php se($user, 'username') ?></h1>
			<?php if (se($user, 'visibility', 0, false)) : ?>
				<p><?php se($user, 'email') ?></p>
			<?php endif; ?>
			<?php if (se($user, 'visibility', 0, false)) : ?>
				<p>Profile: Public</p>
			<?php else : ?>
				<p>Profile: Private</p>
			<?php endif; ?>
		</div>
		<div>
			<h2>Rated Products:</h2>
		</div>
	<?php else : ?>
		<div class="p-4 bg-gray-100 rounded ">
			<p>User does not exist...</p>
		</div>
	<?php endif ?>

</div>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>