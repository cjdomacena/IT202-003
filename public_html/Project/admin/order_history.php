<?php
require(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}
$start = date('Y-m-d', strtotime("-1 month"));
$end = date('Y-m-d', strtotime('today'));
?>

<div class="container mx-auto h-auto my-24">
	<h1>Order History</h1>
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
			<select class="py-1" id="type" onchange="filterHistory(); return false;">
				<option value="all" selected>Filter</option>
				<option value="total">Total</option>
				<option value="created">Date Purchased</option>
				<option value="qty">Quantity </option>
			</select>

			<select class="py-1" id="dir" onchange="filterHistory(); return false;">
				<option value="desc" selected>High to Low</option>
				<option value="asc">Low to High</option>
			</select>
		</div>
	</div>
	<table class="w-full border rounded hidden" id="loading">
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
</div>
<script>
	get_cart_count();
	$(document).ready(
		$.ajax({
			type: 'GET',
			url: './purchase_history.php',
			beforeSend: () => {
				document.getElementById('loading').classList.remove('hidden');
			},
			success: (data) => {
				$('#data').html(data);
			}
		}).done(() => {
			document.getElementById('loading').classList.add('hidden');
		})
	)
	const filterHistory = () => {
		const start = document.getElementById('start');
		const end = document.getElementById('end');
		const type = document.getElementById('type');
		const dir = document.getElementById('dir');
		console.log(type.value);
		console.log(dir.value)
		$.ajax({
			type: 'GET',
			url: './purchase_history.php',
			data: {
				start: start.value,
				end: end.value,
				type: type.value,
				direction: dir.value,
			},
			beforeSend: () => {
				document.getElementById('loading').classList.remove('hidden');
			},
			success: (data) => {
				$('#data').html(data)
			}
		}).done(() => {
			document.getElementById('loading').classList.add('hidden');
		})
	}
</script>


<?php
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>