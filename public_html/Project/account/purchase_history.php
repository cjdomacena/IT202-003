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


$start = date('Y-m-d', strtotime("-1 month"));
$end = date('Y-m-d', strtotime('today'));
$current_page = 1;
if (isset($_GET['page'])) {
	$current_page = se($_GET, 'page', 1, false);
}
$total_pages = ceil(count($orders) / 2);
?>

<div class="container mx-auto h-auto my-24">
	<h1>Purchase History</h1>
	<div class="flex items-center mt-4 justify-between">
		<div class="flex items-center space-x-4">
			<div>
				<label for="date-start">Start</label>
				<input type="date" name="date-start" placeholder="Start date" class="py-1" value="<?php echo $start ?>" id="start" onchange="filterHistory(); return false;" />
			</div>
			<div>
				<label>End</label>
				<input type="date" name="date-end" placeholder="Start date" class="py-1" value="<?php echo $end ?>" id="end" onchange="filterHistory(); return false;" />
			</div>
		</div>
		<div class="flex items-center space-x-4">
			<select class="py-1" id="type" onchange="filterHistory()">
				<option value="all">Filter</option>
				<option value="total">Total</option>
				<option value="created">Date Purchased</option>
				<option value="qty">Quantity </option>
			</select>

			<select class="py-1" id="dir" onchange="filterHistory()">
				<option value="desc">High to Low</option>
				<option value="asc">Low to High</option>
			</select>
		</div>
	</div>
	<table class="w-full border rounded hidden mt-8" id="loading">
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
		<tbody class="divide-y animate-pulse">
			<tr>
				<td class="px-8 py-4 ">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
				<td class="px-8 py-4">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
				<td class="px-8 py-4">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
				<td class="px-8 py-4">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
				<td class="px-8 py-4">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
				<td class="px-8 py-4">
					<div class="p-1 bg-gray-400 rounded-lg"></div>
				</td>
			</tr>

		</tbody>
	</table>
	<div id="data">

	</div>
	<div>
		<?php require('./../utils/pagination.php') ?>
	</div>
</div>
<input id="current-page" value="<?php echo $current_page ?>" class="hidden" />
<input id="row-count" value="<?php se($r, 'row_count') ?>" class="hidden" />
<script>
	get_cart_count();
	let start = document.getElementById('start');
	let end = document.getElementById('end');
	let type = document.getElementById('type');
	let dir = document.getElementById('dir');
	let row_count = document.getElementById('row-count');
	let current_page = document.getElementById('current-page').value;
	const filterHistory = () => {
		$.ajax({
			type: 'GET',
			url: `./getPurchaseHistory.php?page=${current_page}&start=${start.value}&end=${end.value}&type=${type.value}&direction=${dir.value}`,
			data: {
				start: start.value,
				end: end.value,
				type: type.value,
				direction: dir.value,
			},
			beforeSend: () => {
				document.getElementById('loading').classList.remove('hidden');
				const table = document.getElementById('table');
				if (table) {
					table.classList.add('hidden');
				}
			},
		}).done((data) => {
			$('#data').html(data);
			document.getElementById('loading').classList.add('hidden');
			const table = document.getElementById('table');
			table.classList.remove('hidden');


		})

		return false;
	}

	$(document).ready(filterHistory())
</script>
<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>