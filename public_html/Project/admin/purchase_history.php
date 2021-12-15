<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}
if (has_role('seller') || has_role('admin')) {
	$db = getDB();
	$uid = get_user_id();
	$orders = null;

	// $stmt = $db->prepare('SELECT * FROM Orders WHERE user_id = :uid ORDER BY created DESC LIMIT 10');
	// try {
	// 	$stmt->execute([":uid" => $uid]);
	// 	$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// } catch (PDOException $e) {
	// 	flash($e, "bg-red-200");
	// }
	$stmt = $db->prepare('SELECT * FROM Products, OrderItems WHERE Products.id = OrderItems.product_id AND Products.user_id = :uid LIMIT 10');

	try {
		$stmt->execute([":uid" => $uid]);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash($e, "bg-red-200");
	}
}
?>

<div class="container mx-auto h-auto my-24">
	<h1>Order History</h1>
	<table class="w-full mt-4 border rounded">
		<thead>
			<tr class="text-left bg-gray-900 rounded text-gray-50 divide-y">
				<th class="px-8 py-4 text-xs ">ID</th>
				<th class="px-8 py-4 text-xs ">Item</th>
				<th class="px-8 py-4 text-xs ">Order Quantity</th>
				<th class="px-8 py-4 text-xs ">Total Paid</th>
				<th class="px-8 py-4 text-xs ">Date</th>
				<th class="px-8 py-4 text-xs ">View Orders</th>
			</tr>
		</thead>
		<tbody class="divide-y">
			<?php foreach ($orders as $order) : ?>
				<tr class="hover:bg-gray-200">
					<td class="px-8 py-4"><?php se($order, "id") ?></td>
					<td class="px-8 py-4"><?php se($order, "name") ?></td>
					<td class="px-8 py-4">x<?php se($order, "quantity") ?></td>
					<td class="px-8 py-4">$<?php se($order, "cost_on_purchase") ?></td>
					<td class="px-8 py-4"><?php se($order, "created") ?></td>
					<td class="px-8 py-4 cursor-pointer">
						<a href="../cart/order_confirmation.php?order_id=<?php se($order, "order_id"); ?>&type=history"> View Order # <?php se($order, "order_id") ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

<script>
	get_cart_count();
</script>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>