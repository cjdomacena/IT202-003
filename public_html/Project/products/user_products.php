 <?php
	require_once(__DIR__ . "../../../../lib/functions.php");
	require_once(__DIR__ . "../../../../lib/db.php");
	session_start();
	if (!is_logged_in()) {
		redirect(get_url('index.php'));
	}
	$products = [];
	$db = getDB();
	$sort = se($_GET, "sort", "", false);
	$category = se($_GET, "category", "", false);
	$dir = "ASC";
	$search = se($_GET, "search", "", false);
	$params = [];
	$q = "SELECT Products.id, Products.image, Products.id, Products.avg_rating, Products.description,Products.category, Products.cost,Products.name,Users.username, Users.id as uid FROM Products JOIN Users ON (Products.user_id = Users.id) WHERE user_id =:uid AND 1 = 1";
	$params[":uid"] = get_user_id();

	if ($sort == 'filter_by_stock') {
		$q .= ' AND stock = 0';
	}


	switch ($sort) {
		case "filter_by_name":
			$sort = "name";
			$dir = "ASC";
			break;
		case "filter_by_price_desc":
			$sort = "cost";
			$dir = "DESC";
			break;
		case "filter_by_price_asc":
			$sort = "cost";
			$dir = "ASC";
			break;
		case "filter_by_rating_asc":
			$sort = "avg_rating";
			$dir = "ASC";
			break;
		case "filter_by_rating_desc":
			$sort = "avg_rating";
			$dir = "DESC";
			break;
		default:
			$sort = "avg_rating";
			$dir = "DESC";
			break;
	}

	if ($category == "filter_by_accessories") {
		$category = "Accessories";
	} else if ($category == "filter_by_pants") {
		$category = "Pants";
	} else if ($category == "filter_by_shoes") {
		$category = "Shoes";
	} else if ($category == "filter_by_shirts") {
		$category = "Shirts";
	} else {
		$category = "";
	}

	if (!empty($search)) {
		$q .= " AND name like :name";
		$params[":name"] = "%$search%";
	}
	if (!empty($category)) {
		$q .= " AND category = :cat";
		$params[":cat"] = $category;
	}
	if (!empty($sort)) {
		$q .= " ORDER BY $sort $dir";
	}
	$limit = 4;
	$page = se($_GET, 'page', 1, false);
	$q .= " LIMIT :limit OFFSET :offset";
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$stmt = $db->prepare($q);
	$offset = ($page - 1) * $limit;
	try {
		if (count($params) < 1) {
			$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
			$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
			$stmt->execute();
			$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$params['limit'] = $limit;
			$params['offset'] = $offset;
			$stmt->execute($params);
			$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		flash("<pre>" . $e . "</pre>", "bg-red-200");
	}


	?>


 <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4 container" id="card-container">
 	<?php foreach ($products as $index => $product) : ?>
 		<div class="bg-white shadow-md border border-gray-200 rounded-lg h-auto min-h-56 flex flex-col ">
 			<img class="rounded-t-lg object-cover max-h-64 w-full justify-self-start" src="<?php echo $product['image'] ?>" alt="" />
 			<div class="p-5 flex flex-col space-y-4  h-auto max-w-md">
 				<div>
 					<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>">
 						<h5 class="text-gray-900 font-bold text-2xl tracking-tight "><?php echo $product['name'] ?></h5>
 					</a>
 					<?php if (se($product, 'avg_rating', 0, false) == 0) : ?>
 						<span class="text-xs text-gray-500">Product Rating: Not available</span>
 					<?php else : ?>
 						<span class="text-xs">Product Rating: <?php se($product, 'avg_rating') ?></span>
 					<?php endif ?>

 				</div>
 				<div>
 					<p class="font-normal text-gray-700 mb-3 truncate "><?php echo $product['description'] ?>
 					</p>
 					<p class="text-indigo-800 font-medium text-sm text-center inline-flex items-center">
 						<?php

							$cost = doubleval(se($product, 'cost', "", false));
							echo "$" . $cost;
							?>
 					</p>
 				</div>

 				<div class="mt-2 flex justify-between">
 					<span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"><?php se($product, 'category') ?></span>
 					<?php if (se($product, 'stock', -1, false) <= 0) : ?>
 						<span class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Out of stock</span>
 					<?php endif; ?>
 					<?php if (se($product, 'stock', -1, false) > 0) : ?>
 						<span class="bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Available stock: <?php se($product, 'stock', -1, true) ?></span>
 					<?php endif; ?>
 				</div>
 				<div class="cursor-pointer">
 					<span class="text-blue-800 text-xs font-semibold py-0.5 rounded hover:text-gray-900">Seller:<a href="profile_view.php?user=<?php se($product, 'uid') ?>"> <?php se($product, 'username') ?></a></span>
 				</div>
 				<div class="flex space-x-4">
 					<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-indigo-800 font-medium text-sm  text-center justify-self-end">
 						View
 					</a>
 					<a href="<?php echo get_url('./products/edit_product.php') ?>?id=<?php se($product, 'id', -1, true); ?>" class="text-yellow-600 font-medium text-sm text-center justify-self-end">
 						Edit
 					</a>
 					<div>
 						<!-- Modal toggle -->
 						<button class="text-red-500 hover:text-red-900 font-medium rounded-lg text-sm" type="button" data-modal-toggle="popup-modal">
 							Delete
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
 										<button data-modal-toggle="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" onclick="deleteProduct(this)" value="<?php se($product, 'id') ?>">
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
 		</div>
 	<?php endforeach ?>
 </div>
 <script>
 	function deleteProduct(e) {
 		$.ajax({
 			type: 'POST',
 			url: 'api/delete_product.php',
 			data: {
 				product_id: e.value
 			},
 		}).done(() => {
 			location.replace('shop.php')
 		})
 	}
 </script>

 <?php
	require_once(__DIR__ . "../../../../partials/flash.php");
	?>
 <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>