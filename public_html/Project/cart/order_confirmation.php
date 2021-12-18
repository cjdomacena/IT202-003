<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}

if (isset($_GET["order_id"])) {
	$isHistory = false;
	if (isset($_GET["type"])) {
		$isHistory = true;
	}
	$order_id = se($_GET, "order_id", "", false);
	$db = getDB();
	$orders;
	$userInfo;
	$stmt = $db->prepare('SELECT OrderItems.quantity as qty, OrderItems.id as order_items_id, Products.cost as true_cost, Products.name, Products.description, OrderItems.cost_on_purchase as cost, Products.image, Products.id as product_id FROM((Products INNER JOIN OrderItems ON Products.id = OrderItems.product_id AND OrderItems.order_id = :order_id) )');
	try {
		$stmt->execute([":order_id" => $order_id]);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash($e, "bg-red-200");
	}

	$stmt = $db->prepare('SELECT * FROM Orders WHERE id = :order_id');
	try {
		$stmt->execute([":order_id" => $order_id]);
		$userInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash($e, "bg-red-200");
	}
} else {
	redirect(get_url('index.php'));
}

?>

<div class="container mx-auto h-auto mt-8 space-y-4">

	<div>
		<div class="w-full p-4 bg-indigo-200 rounded">

			<?php if ($isHistory) : ?>
				<h1>Purchase History</h1>
				<h2>Order #<?php echo $order_id ?></h2>
			<?php else : ?>
				<h1>Order Confirmation #<?php echo $order_id ?></h1>
				<h2 class="text-lg font-semibold text-gray-900">Thank you for your purchase!</h2>
			<?php endif ?>
		</div>
		<div class="my-2">
			<div class="space-y-2 mt-4">
				<h1 class="text-lg font-bold">Shipping Info</h1>
				<div>
					<p class="text-lg"><?php se($userInfo[0], "fName") ?> <?php se($userInfo[0], "lName") ?></p>
					<p><?php se($userInfo[0], "address") ?> </p>
					<p><?php se($userInfo[0], "state") ?>,<?php se($userInfo[0], "zip") ?>,</p>
					<p>USA</p>
				</div>
			</div>

		</div>
		<hr />
		<div class="w-full grid grid-cols-1 gap-4">
			<h3 class="mt-4 font-bold">Order Summary: </h3>
			<?php foreach ($orders as $order) : ?>
				<div class="flex space-x-2">
					<img src="<?php se($order, "image") ?>" class="h-24 w-24 object-cover" />
					<div class="flex justify-between w-full">
						<div>
							<h4 class="text-lg"><?php se($order, "name") ?></h4>
							<p class="text-sm"> $<?php se($order, "true_cost") ?></p>

						</div>
						<div>
							<p>Subtotal: $<?php se($order, "cost") ?> </p>
							<p> x<?php se($order, "qty") ?></p>
						</div>
					</div>
				</div>
				<hr />
			<?php endforeach ?>

		</div>

	</div>
	<div class="h-auto pt-8">
		<a href="<?php echo get_url('index.php') ?>" class="bg-indigo-200 rounded px-6 py-2 text-indigo-900 hover:bg-indigo-300">Go to home</a>
	</div>

</div>


<?php
require_once(__DIR__ . "../../../../partials/flash.php");
?>

<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>