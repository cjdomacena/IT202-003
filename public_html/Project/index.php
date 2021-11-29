<?php
require_once(__DIR__ . '/../../partials/nav.php')
?>

<div class=" h-96 w-full bg-gray-100 mx-auto text-gray-900 grid place-items-center rounded border">
	<h1 class="text-2xl font-bold">Welcome to my Basic Shop</h1>
</div>

<div class="container mx-auto my-16">
	<div class="flex justify-between">
		<h1 class="underline capitalize" id="filter_title"></h1>
		<select class=" rounded" id="filter" name="Sort" onchange="filter_items()">
			<option value="all_products">All</option>
			<option value="filter_by_name">Name (A-Z)</option>
			<option value="filter_by_price_asc">Price (Low to High)</option>
			<option value="filter_by_price_desc">Price (High to Low)</option>
		</select>
	</div>
	<div id="data">

	</div>

</div>

<script>

</script>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>

<!-- Just for flash -->
<script>
	check();
	get_cart_count();
	$(document).ready(

		$.ajax({
			type: "GET",
			url: "./products/all_products.php",
			data: "filter=" + 'all_products',
			success: (data) => {
				let selected = $("select").val();
				$("#data").html(data)
				let fitler_title = document.getElementById("filter_title");
				selected = selected.split("_").join(" ");
				fitler_title.innerText = selected;
			}
		})
	)

	function filter_items() {
		let selected = $("select").val();
		console.log(selected)
		$.ajax({
			type: "GET",
			url: "./products/all_products.php",
			data: "filter=" + selected,
			success: (data) => {
				$("#data").html(data);
				const fitler_title = document.getElementById("filter_title");
				selected = selected.split("_").join(" ");
				fitler_title.innerText = selected;
			}
		})
	}
</script>