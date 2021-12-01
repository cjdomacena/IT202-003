<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!is_logged_in() || has_role("default")) {
	die(header("Location: " . get_url("index.php")));
}
if (isset($_GET["id"])) {
	$id = se($_GET, "id", -1, false);
	if ($id != -1) {
		$db = getDB();
		$product = "";
		$stmt = $db->prepare('SELECT * FROM Products WHERE id = :id');
		try {
			$stmt->execute([':id' => $id]);
			$product = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			flash("Something went wrong...", "bg-red-200");
		}
	}
}
?>
<div class="container mx-auto my-8" id="form-container">
	<input type="number" class="invisible scale-0 h-0 w-0 p-0 m-0" id="product_id" value="<?php echo $id ?>">
	<div class="w-1/2 mx-auto space-y-8 border p-4 rounded shadow">

		<div class="flex justify-between">
			<h1>Edit Product </h1>
			<span class="inline-flex rounded-md invisible" id="spinner">
				<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
				Processing
			</span>
		</div>
		<form method="POST" onsubmit="add_new_product(event,'edit_product'); return false;" enctype="multipart/form-data" class="space-y-8">
			<!-- Product Name  -->
			<div>
				<label for="product_name" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Name</label>
				<input type="text" id="product_name" name="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php se($product, "name", "", true) ?>" required>
			</div>
			<!-- Product Description -->
			<div>
				<label for="product_description" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">Description</label>
				<textarea id="product_description" name="product_description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Product Description..." required>
				<?php se($product, "description", "", true) ?>
				</textarea>
			</div>
			<!-- Product Cost  -->
			<div>
				<label for="product_cost" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Cost</label>
				<input type="number" min="0" id="product_cost" name="product_cost" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php se($product, "cost", "", true) ?>" required>
			</div>

			<!-- Product Stock Qty  -->
			<div>
				<label for="product_stock" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Stock Qty.</label>
				<input type="number" id="product_stock" name="product_stock" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="0" max="99" value="1" value="<?php se($product, "stock", "", true) ?>" required>
			</div>
			<!-- Product Category  -->
			<div>
				<label for="product_category" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">Product Category</label>
				<select id="product_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="get_category()">
					<?php if ($product["category"] == "Shoes") : ?>
						<option selected>Shoes</option>
						<option>Shirts</option>
						<option>Pants</option>
						<option>Accessories</option>
					<?php elseif ($product["category"] == "Shirts") : ?>
						<option>Shoes</option>
						<option selected>Shirts</option>
						<option>Pants</option>
						<option>Accessories</option>
					<?php elseif ($product["category"] == "Pants") : ?>
						<option>Shoes</option>
						<option>Shirts</option>
						<option selected>Pants</option>
						<option>Accessories</option>
					<?php elseif ($product["category"] == "Accessories") : ?>
						<option>Shoes</option>
						<option>Shirts</option>
						<option>Pants</option>
						<option selected>Accessories</option>
					<?php endif; ?>
				</select>
			</div>

			<!-- Product Visibility  -->
			<div class="w-64">
				<p class="text-sm font-md mb-3">Product Visbility</p>
				<label for="product_visiblity" class="flex items-center cursor-pointer relative mb-4">
					<input type="checkbox" id="product_visiblity" class="sr-only" name="product_visiblity" onclick="get_visibility()" value=<?php echo se($product, "visibility", "", false) ? 1 : 0;  ?>>
					<div class="toggle-bg bg-gray-200 border border-gray-200 h-6 w-11 rounded-full dark:bg-gray-700 dark:border-gray-600"></div>
					<span class="ml-3 text-gray-900 text-sm font-medium dark:text-gray-300"></span>
				</label>
			</div>

			<!-- Product Image Upload  -->
			<div class="w-64 image-upload">
				<label class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300" for="product_image">Upload Image (max: 32MB)</label>
				<input class="block w-full cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 dark:text-gray-400 focus:outline-none focus:border-transparent text-sm rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="product_image" name="product_image" type="file">
			</div>
			<!-- Submit reset  -->
			<div class="flex space-x-4">
				<button type="submit" value="Submit" class="rounded-lg bg-green-400 text-sm font-medium text-white px-4 py-2 hover:bg-green-200 hover:text-green-700 mr-3 mb-3">Submit</button>

			</div>
		</form>
		<div>
			<!-- Modal toggle -->
			<button class="block text-red-500 bg-red-100 hover:bg-red-400 focus:ring-4 focus:ring-red-200 font-medium rounded-lg text-sm px-5 text-center" type="button" data-modal-toggle="popup-modal">
				Delete Product
			</button>
			<div class="hidden overflow-x-hidden overflow-y-auto fixed top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center h-modal sm:h-full" id="popup-modal">
				<div class="relative w-full max-w-md px-4 h-full md:h-auto">
					<!-- Modal content -->
					<div class="bg-white rounded-lg shadow relative dark:bg-gray-700">
						<!-- Modal header -->
						<div class="flex justify-end p-2">
							<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
								</svg>
							</button>
						</div>
						<!-- Modal body -->
						<div class="p-6 pt-0 text-center">
							<svg class="w-14 h-14 text-gray-400 dark:text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
							<h3 class="text-lg font-normal text-gray-500 mb-5 dark:text-gray-400">Are you sure you want to remove this Item?</h3>
							<button data-modal-toggle="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" onclick="delete_product()">
								Yes, I'm sure
							</button>
							<button data-modal-toggle="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">No, cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once(__DIR__ . "../../../../partials/flash.php");
?>