 <?php
	require_once(__DIR__ . "../../../../lib/functions.php");
	require_once(__DIR__ . "../../../../lib/db.php");
	session_start();

	if (is_logged_in()) {
		$products = [];
		$db = getDB();
		$sort = se($_GET, "sort", "", false);
		$category = se($_GET, "category", "", false);
		$dir = "ASC";
		$search = se($_GET, "search", "", false);
		$params = [];
		$q = "SELECT * FROM Products WHERE 1 = 1";

		if ($sort == "filter_by_name") {
			$sort = "name";
			$dir = "ASC";
		} else if ($sort == "filter_by_price_desc") {
			$sort = "cost";
			$dir = "DESC";
		} else if ($sort == "filter_by_price_asc") {
			$sort = "cost";
			$dir = "ASC";
		} else {
			$sort = "name";
			$dir = "ASC";
		};
		
		if($category == "filter_by_accessories"){
			$category = "Accessories";
		}
		else if($category == "filter_by_pants"){
			$category = "Pants";
		}
		else if($category == "filter_by_shoes"){
			$category = "Shoes";
		}
		else if($category == "filter_by_shirts"){
			$category = "Shirts";
		}
		else {
			$category = "";
		}

		if(!empty($search)){
			$q .=" AND name like :name";
			$params[":name"] = "%$search%";
		}
		if(!empty($category)){
			$q .=" AND category = :cat";
			$params[":cat"] = $category;
		}
		if(!empty($sort)){
			$q .=" ORDER BY $sort $dir";
		}

		$stmt = $db->prepare($q);
		try{
			if(count($params) < 1){
				$stmt->execute();
				$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
				// echo json_encode($products);
			}else {
				$stmt->execute($params);
				$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
				// echo json_encode($products);
			}
		}catch(PDOException $e){
			flash("<pre>" . $e . "</pre>", "bg-red-200");
		}

	}

	?>


 <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4 w-full" id="card-container">
 	<?php foreach ($products as $index => $product) : ?>
 		<div class="bg-white shadow-md border border-gray-200 rounded-lg w-full">
 			<a href="#">
 				<img class="rounded-t-lg object-cover h-64 w-full" src="<?php echo $product['image'] ?>" alt="" />
 			</a>
 			<div class="p-5">
 				<a href="#">
 					<h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2"><?php echo $product['name'] ?></h5>
 				</a>
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
 				<div class="flex pt-4 justify-between">
 					<div class="space-x-4">
 						<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-indigo-800 font-medium text-sm  text-center justify-self-end">
 							View Product
 						</a>
 						<a href="<?php echo get_url('./products/edit_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-red-800 font-medium text-sm text-center justify-self-end">
 							Edit Product
 						</a>
 					</div>
 				</div>
 			</div>
 		</div>

 	<?php endforeach ?>
 </div>