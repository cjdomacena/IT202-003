 <?php
	require_once(__DIR__ . "../../../../lib/functions.php");
	require_once(__DIR__ . "../../../../lib/db.php");
	session_start();


	$products = [];
	$db = getDB();
	$sort = se($_GET, "sort", "", false);
	$category = se($_GET, "category", "", false);
	$dir = "ASC";
	$search = se($_GET, "search", "", false);

	$params = [];
	$q = "SELECT * FROM Products WHERE visibility = 1 AND stock > 0  AND 1=1";



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
	$offset = ($page - 1) * 5;
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


 <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4 w-full" id="card-container">
 	<?php foreach ($products as $index => $product) : ?>
 		<div class="bg-white shadow-md border border-gray-200 rounded-lg h-auto min-h-56 flex flex-col justify-evenly">
 			<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>">
 				<img class="rounded-t-lg object-cover h-64 w-full" src="<?php echo $product['image'] ?>" alt="" />
 			</a>
 			<div class="p-5 flex flex-col space-y-4 max-w-md">
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

 				<div>
 					<span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"><?php se($product, 'category') ?></span>
 				</div>

 				<div class="flex space-x-4">
 					<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-indigo-800 font-medium text-sm  text-center justify-self-end">
 						View
 					</a>
 					<button class="text-indigo-800 font-medium text-sm text-center inline-flex items-center" id="<?php echo $product["id"]; ?>" onclick="add_to_cart(this)">
 						Add to Cart
 					</button>
 				</div>

 			</div>
 		</div>

 	<?php endforeach ?>
 </div>
 