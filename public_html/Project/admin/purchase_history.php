<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();

if (has_role('seller') || has_role('admin')) {
	$start = "";
	$end = "";
	$db = getDB();
	$uid = get_user_id();
	$orders = null;
	$q = "SELECT * FROM Products, OrderItems WHERE Products.id = OrderItems.product_id AND Products.user_id = :uid";
	$params = [];
	$params[':uid'] = (int)$uid;

	$start = se($_GET, 'start', date('Y-m-d', strtotime("-1 month")), false);
	$end = se($_GET, 'end', date('Y-m-d'), false);

	$q.= " AND OrderItems.created BETWEEN :start and :end ";
	$params[':start'] = $start;
	$params[':end'] = $end;

	$type = se($_GET, 'type', 'all', false);
	$direction = se($_GET, 'direction', 'desc',false);

	switch($type){
		case 'all':
			$q.= ' ORDER BY Products.name ';
			break;
		case 'total':
			$q .= ' ORDER BY cost_on_purchase ';
			break;
		case 'created':
			$q .= ' ORDER BY OrderItems.created';
			break;
		case 'qty':
			$q .= ' ORDER BY quantity ';
			break;
	}

	if($direction == 'asc'){
		$q .= ' ASC ';
	}
	else{
		$q .= ' DESC ';
	}


	$stmt = $db->prepare($q);
	try {
		$stmt->execute($params);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash(var_export($e, true), 'bg-red-200');
	}
}
?>


<div class="flex items-center mt-4 justify-between">
	<?php if (!empty($orders)) : ?>
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
	<?php else : ?>
		<div class="w-full mt-4">
			<div class="p-4 w-full bg-gray-100">
				<h2>No records found</h2>
			</div>
		</div>
	<?php endif; ?>