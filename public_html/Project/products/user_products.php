 <?php
	require_once(__DIR__ . "../../../../lib/functions.php");
	require_once(__DIR__ . "../../../../lib/db.php");
	session_start();
	if (is_logged_in()) {
		if (isset($_GET["filter"])) {
			$db = getDB();
			$col = se($_GET, 'filter', "all_products", false);
			$user_id = get_user_id();
			if ($col == 'filter_by_price_asc') {
				$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY cost ASC  LIMIT 10");
			} else if ($col == 'filter_by_price_desc') {
				$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY cost DESC  LIMIT 10");
			} else if ($col == 'filter_by_name') {
				$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY name ASC  LIMIT 10");
			} else {
				$stmt = $db->prepare("SELECT * FROM Products WHERE (user_id = :uid) ORDER BY name ASC LIMIT 10");
			}

			try {
				$stmt->execute([":uid" => $user_id]);
				$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				flash("Something Went Wrong...", "bg-red-200");
			}
		}
	} else {
		die(header("Location: " . get_url("index.php")));
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
 					<p class="font-normal text-gray-700 mb-3"><?php echo $product['description'] ?>
 					</p>
 					<p class="text-indigo-800 font-medium text-sm text-center inline-flex items-center">
 						<?php

							$cost = doubleval(se($product, 'cost', "", false));
							echo "$" . $cost;
							?>
 					</p>
 				</div>
 				<div class="flex pt-4 justify-between">
 					<button class="text-indigo-800 font-medium text-sm text-center inline-flex items-center " id="<?php echo $product["id"]; ?>" onclick="add_to_cart(this)">
 						Add to Cart
 					</button>
 					<div class="space-x-4">
 						<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-indigo-800 font-medium text-sm  text-center justify-self-end">
 							View Product
 						</a>
 						<a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id'); ?>" class="text-red-800 font-medium text-sm text-center justify-self-end">
 							Edit Product
 						</a>
 					</div>
 				</div>
 			</div>
 		</div>
 	<?php endforeach ?>
 </div>