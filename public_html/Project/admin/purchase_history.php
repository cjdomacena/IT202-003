<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}
if (has_role('seller') || has_role('admin')) {
	$start = "";
	$end = "";
	$db = getDB();
	$uid = get_user_id();
	$orders = null;
	$q = "SELECT * FROM Products, OrderItems WHERE Products.id = OrderItems.product_id AND Products.user_id = :uid";
	$params = [];
	$params[':uid'] = (int)$uid;

	$start = se($_GET,'start', date('Y-m-d',strtotime("-1 month")),false);
	$end = se($_GET, 'start', date('Y-m-d'), false);

	if($start){
		$q .= " AND OrderItems.created >= :start";
		$params[':start'] = $start;
	}
	if ($end) {
		$q .= " AND OrderItems.created <= :end";
		$params[':end'] = $end;
	}


	$stmt = $db->prepare($q);
	try{
		$stmt->execute($params);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		flash(var_export($e,true),'bg-red-200');
	}


	// $stmt = $db->prepare('SELECT * FROM Products, OrderItems WHERE Products.id = OrderItems.product_id AND Products.user_id = :uid LIMIT 10');
	// try {
	// 	$stmt->execute([":uid" => $uid]);
	// 	$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// } catch (PDOException $e) {
	// 	flash($e, "bg-red-200");
	// }

	// if (count($orders) == 1) {
	// 	$start = date('Y-m-d', strtotime($orders[0]['created']));
	// 	$end = date('Y-m-d', strtotime($orders[0]['created']));
	// } else if (count($orders) > 1) {
	// 	$start = date('Y-m-d', strtotime($orders[0]['created']));
	// 	$end = date('Y-m-d', strtotime($orders[count($orders) - 1]['created']));
	// }

}
?>

<div class="container mx-auto h-auto my-24">
	<h1>Order History</h1>
	<div class="flex items-center mt-4 justify-between">
		<div class="flex items-center space-x-4">
			<div>
				<label for="date-start">Start</label>
				<input type="date" name="date-start" placeholder="Start date" class="py-1" value="<?php echo $start ?>" id="start" onchange="filterHistory(); return false;"/>
			</div>
			<div>
				<label>End</label>
				<input type="date" name="date-end" placeholder="Start date" class="py-1" value="<?php echo $end ?>" id="end" />
			</div>
		</div>
		<div class="flex items-center space-x-4">
			<select class="py-1" id="type">
				<option value="all" selected>Filter</option>
				<option value="total">Total</option>
				<option value="created">Date Purchased</option>
				<option value="qty">Quantity </option>
			</select>

			<select class="py-1" id="dir">
				<option value="desc">High to Low</option>
				<option value="asc">Low to High</option>
			</select>

		</div>
	</div>
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
	const filterHistory = () => {
		const start = document.getElementById('start');
		const end = document.getElementById('end');
		const type = document.getElementById('type');
		const dir = document.getElementById('dir');
		$.ajax({
			type: 'GET',
			url: './purchase_history.php',
			data: {
				start: start.value,
				end: end.value,
				type: type.value,
				dir: dir.value,
			},
			success: ()=>{
				location.reload();
			}
		})
	}
</script>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>