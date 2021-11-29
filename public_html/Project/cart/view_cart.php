<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();
$total = 0;
if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}
if (isset($_POST["type"])) {
	$db = getDB();
	$id = get_user_id();
	$type = se($_POST, "type", "", false);
	switch ($type) {
		case "update_qty":
			$qty = $_POST["quantity"];
			$cartID = $_POST["cart"];
			$stmt = $db->prepare("UPDATE Cart SET quantity = :q WHERE id = :cart_id");
			try {
				$stmt->execute([":q" => $qty, ":cart_id" => $cartID]);
				flash("Cart Successfully Updated", "bg-green-200", 1000, "fade");
			} catch (PDOException $e) {
				flash("Something Went wrong...", "bg-red-200", 1000, "fade");
			}
			break;
		case "delete_item":
			$cartID = se($_POST, "cart", -1, false);
			if ($cartID == -1) {
				flash("Something went wrong...", "bg-red-200");
				break;
			}
			$stmt = $db->prepare('DELETE FROM Cart WHERE id = :cart_id');
			try {
				$stmt->execute([":cart_id" => $cartID]);
				flash("Successfully Removed from cart", "bg-red-200");
			} catch (PDOException $e) {
				flash("Something Went wrong...", "bg-red-200");
			}
			break;
		case "delete_all":
			$stmt = $db->prepare("DELETE FROM Cart WHERE user_id = :uid");
			try {
				$stmt->execute([":uid" => $id]);
				flash("Cart Successfully Updated", "bg-green-200");
			} catch (PDOException $e) {
				flash("Something went wrong...", "bg-red-200");
			}
		default:
			break;
	}

	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		json_encode($r);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
} else { // First load
	$db = getDB();
	$id = get_user_id();
	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		json_encode($r);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
}



?>

<div class="flex space-x-4 justify-between">
	<div class="w-8/12 mx-auto">
		<div class="my-8 py-4 rounded border">
			<h1 class="ml-4"><?php echo ucFirst(get_username()) ?>'s Cart</h1>
		</div>
		<?php if (count($r) < 1) : ?>
			<div class="p-4 bg-gray-100 rounded">
				<h2 class="text-center py-4">Cart is currently empty.</h2>
			</div>
		<?php endif; ?>
		<div class=" grid-cols-1 divide-solid divide-y-2 my-4">
			<?php foreach ($r as $index => $item) : ?>
				<?php $total += $item["cost"] * $item["quantity"] ?>
				<div class="hover:bg-gray-100 p-4">
					<div class="flex justify-between">
						<div class="flex mb-4">
							<img class="w-24 h-24 object-fill rounded mr-4" src="<?php echo $item["image"] ?>" />
							<div>
								<h1 class="text-xl font-bold"><?php echo $item['name'] ?></h1>
								<p class="truncate"><?php echo $item['description'] ?></p>
							</div>
						</div>
						<div>
							<p>Total: $<?php echo $item["cost"] * $item["quantity"] ?></p>
							<input type="number" min=0 max=99 value="<?php echo $item["quantity"]; ?>" name="quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 my-4 w-24" />
						</div>
					</div>
					<div class="flex space-x-4 mt-4">
						<button class="text-indigo-800" onclick="update_qty(<?php echo $item['cart_id'] ?>)">Update</button>
						<button class="text-red-600" onclick="remove_item(<?php echo $item['cart_id'] ?>)">Remove</button>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<hr class="my-4" />
		<div class="rounded border-top flex justify-between">
			<div class="p-4">
				<h3>Total: $<?php echo $total ?></h3>
				<p> Product Count: <?php echo count($r)?> </p>
			</div>
			<!-- Modal toggle -->
			<button class="block text-red-500 bg-red-100 hover:bg-red-400 focus:ring-4 focus:ring-red-200 font-medium rounded-lg text-sm px-5 text-center" type="button" data-modal-toggle="popup-modal">
				Clear Cart
			</button>

			<!-- Delete Product Modal -->
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
							<h3 class="text-lg font-normal text-gray-500 mb-5 dark:text-gray-400">Are you sure you want to clear your cart?</h3>
							<button data-modal-toggle="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" onclick="remove_all_items()">
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

<script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>