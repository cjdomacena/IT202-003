<?php
require(__DIR__ . "/../../partials/nav.php");

$categories = null;

$db = getDB();
$stmt = $db->prepare("SELECT DISTINCT category FROM Products");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<div class=" h-96 w-full bg-gray-100 mx-auto text-gray-900 grid place-items-center rounded border">
	<h1 class="text-2xl font-bold">Welcome to my Basic Shop</h1>
</div>

<div class="container mx-auto my-16">
	<div class="flex justify-between">
		<h1 class="underline capitalize" id="filter_title">All Products</h1>
		<div class="flex items-center space-x-2">
			<div class="relative mr-3 md:mr-0 hidden md:block">
				<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
					<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
					</svg>
				</div>
				<input type="text" id="shop_search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." name="shop_search" onchange="home_filter()">
			</div>
			<select class="rounded" id="shop_sort" name="shop_sort" onchange="home_filter()">
				<option value="">Sort</option>
				<option value="filter_by_name">Name (A-Z)</option>
				<option value="filter_by_price_asc">Price (Low to High)</option>
				<option value="filter_by_price_desc">Price (High to Low)</option>
			</select>
			<select class="rounded" id="shop_category" name="shop_category" onchange="home_filter()">
				<option value="">Category</option>
				<?php foreach ($categories as $category) : ?>
					<option value="filter_by_<?php echo strtolower(se($category, "category", "", false)) ?>"><?php se($category, "category", "", true) ?></option>
				<?php endforeach; ?>
			</select>
			<button type="button" class="bg-gray-100 px-4 py-2 rounded text-sm" onclick="clearAllFilters()"> Clear All Filters </button>
		</div>
	</div>
	<div id="userItems">

	</div>
</div>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>

<script>
	get_cart_count();
	$(document).ready(
		$.ajax({
			type: "GET",
			url: "./products/all_products.php",
			data: {
				sort: "all_products",
			},
			success: (data) => {
				$("#userItems").html(data);
			}
		})
	)

	function home_filter() {
		const sort = document.getElementById("shop_sort").value;
		const category = document.getElementById("shop_category").value;
		const q = document.getElementById("shop_search").value;
		$.ajax({
			type: 'GET',
			url: "./products/all_products.php",
			data: {
				sort: sort,
				category: category,
				search: q,
			},
			success: (data) => {
				$("#userItems").html(data);
			}
		})
	}

	function clearAllFilters() {
		const sort = document.getElementById("shop_sort");
		const category = document.getElementById("shop_category");
		const q = document.getElementById("shop_search");
		sort.value = "";
		category.value = ""
		q.value =""
	}
</script>