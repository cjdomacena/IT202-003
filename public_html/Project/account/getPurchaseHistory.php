<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();
if (has_role('shopper') || has_role('admin')) {
	$start = "";
	$end = "";
	$db = getDB();
	$uid = get_user_id();
	$orders = null;
	$q = "SELECT * FROM Orders JOIN OrderItems ON OrderItems.order_id = Orders.id WHERE Orders.user_id = :uid";
	$params = [];
	$params[':uid'] = (int)$uid;

	$start = se($_GET, 'start', date('Y-m-d', strtotime("-1 month")), false);
	$end = se($_GET, 'end', date('Y-m-d'), false);

	$q .= " AND Orders.created BETWEEN :start and :end ";
	$params[':start'] = $start;
	$params[':end'] = $end;

	$type = se($_GET, 'type', 'all', false);
	$direction = se($_GET, 'direction', 'desc', false);
	switch ($type) {
		case 'all':
			$q .= ' ORDER BY OrderItems.order_id ';
			break;
		case 'total':
			$q .= ' ORDER BY OrderItems.cost_on_purchase ';
			break;
		case 'created':
			$q .= ' ORDER BY OrderItems.created';
			break;
		case 'qty':
			$q .= ' ORDER BY OrderItems.quantity ';
			break;
	}

	if ($direction == 'asc') {
		$q .= ' ASC ';
	} else {
		$q .= ' DESC ';
	}
	$row_count = se($_GET, 'rowCount', 4, false);
	if ($row_count >= 2) {
		$limit = 2;
	} else {
		$limit = $row_count;
	}

	$page = se($_GET, 'page', 1, false);

	$q .= " LIMIT :offset, :limit";

	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$stmt = $db->prepare($q);
	$offset = ($page - 1) * 2;
	try {
		$params[':limit'] = (int)$limit;
		$params[':offset'] = (int)$offset;
		$stmt->execute($params);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash(var_export($e, true), 'bg-red-200');
	}
	$row_count = count($orders);
	echo "OFFSET: $offset, LIMIT: $limit, TYPE: $type, DIRECTION: $direction ";
	$total = 0;
	if (!empty($orders)) {
		foreach ($orders as $order) {
			$total += $order['quantity'] * $order['cost_on_purchase'];
		}
	}
}
$total = 0;
?>


<div class="mt-4" id="table">
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
					<?php $total += $order['cost_on_purchase'] * $order['quantity']?>
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
	<div class="w-full p-4 bg-gray-100">
		<h1>Total: <?php echo $total ?></h1>
	</div>
	<input value="<?php se($row_count) ?>" class="hidden" id="row-count" />
</div>