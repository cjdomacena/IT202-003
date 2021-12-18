<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}

$db = getDB();
$uid = get_user_id();
$orders = null;

$stmt = $db->prepare('SELECT * FROM Orders WHERE user_id = :uid ORDER BY created DESC LIMIT 10');
try {
	$stmt->execute([":uid" => $uid]);
	$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	flash($e, "bg-red-200");
}

?>

<div class="container mx-auto h-auto my-24">
	<h1>Purchase History</h1>

	<table class="w-full mt-4 border rounded">
		<thead>
			<tr class="text-left bg-gray-900 rounded text-gray-50 divide-y">
				<th class="px-8 py-4 text-xs ">ID</th>
				<th class="px-8 py-4 text-xs ">Shipping Information</th>
				<th class="px-8 py-4 text-xs ">Total Paid</th>
				<th class="px-8 py-4 text-xs ">Date</th>
				<th class="px-8 py-4 text-xs ">View Orders</th>
			</tr>
		</thead>
		<tbody class="divide-y">
			<?php foreach ($orders as $order) : ?>
				<tr class="hover:bg-gray-200">
					<td class="px-8 py-4"><?php se($order, "id") ?></td>
					<td class="px-8 py-4"><?php se($order, "address") ?>, <?php se($order, "state") ?></td>
					<td class="px-8 py-4">$<?php se($order, "total_price") ?></td>
					<td class="px-8 py-4"><?php se($order, "created") ?></td>
					<td class="px-8 py-4 cursor-pointer">
						<a href="../cart/order_confirmation.php?order_id=<?php se($order, "id"); ?>&type=history"> View Order # <?php se($order, "id") ?></a>
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
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>