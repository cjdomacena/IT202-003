<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!is_logged_in() || has_role("default")) {
	die(header("Location: " . get_url("index.php")));
}
?>
<script>
	let product_image = "";

	function storeImageURL(event) {
		let files = event.target.fileToUpload.files;
		if (files.length > 0) {
			let file = files[0];
			storage.ref().child("images/" + file.name).put(file).then(res => {
				res.ref.getDownloadURL().then((downloadURL) => {
					//this is the url you'd save in the database
					product_image = downloadURL;
				});
			}).catch(err => {
				flash(err, "bg-red-200", 1000, "fade");
			})
		}
	}
</script>
<div class="container mx-auto my-8" id="form-container">

	<div class="w-1/2 mx-auto space-y-8 border p-4 rounded shadow">

		<div class="flex justify-between">
			<h1>Add New Product </h1>
			<span class="inline-flex rounded-md invisible" id="spinner">
				<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
				Processing
			</span>
		</div>
		<form method="POST" onsubmit="add_new_product(event); return false;" enctype="multipart/form-data" class="space-y-8">
			<!-- Product Name  -->
			<div>
				<label for="product_name" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Name</label>
				<input type="text" id="product_name" name="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			</div>
			<!-- Product Description -->
			<div>
				<label for="product_description" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">Description</label>
				<textarea id="product_description" name="product_description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Product Description..." required></textarea>
			</div>
			<!-- Product Cost  -->
			<div>
				<label for="product_cost" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Cost</label>
				<input type="number" min="0" id="product_cost" name="product_cost" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			</div>

			<!-- Product Stock Qty  -->
			<div>
				<label for="product_stock" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Product Stock Qty.</label>
				<input type="number" id="product_stock" name="product_stock" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" min="0" max="99" value="1" required>
			</div>
			<!-- Product Category  -->
			<div>
				<label for="product_category" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">Product Category</label>
				<select id="product_category" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="get_category()">
					<option selected>Shoes</option>
					<option>Shirts</option>
					<option>Pants</option>
					<option>Accessories</option>
				</select>
			</div>

			<!-- Product Visibility  -->
			<div class="w-64">
				<p class="text-sm font-md mb-3">Product Visbility</p>
				<label for="product_visiblity" class="flex items-center cursor-pointer relative mb-4">
					<input type="checkbox" id="product_visiblity" class="sr-only" name="product_visiblity" onclick="get_visibility()" unchecked>
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
				<button type="reset" value="Reset" class="rounded-lg bg-gray-200 text-sm font-medium px-4 py-2 hover:bg-gray-100 hover:text-gray-700 mr-3 mb-3 ">Reset</button>
			</div>
		</form>
	</div>
</div>

<?php
require_once(__DIR__ . "../../../../partials/flash.php");
?>