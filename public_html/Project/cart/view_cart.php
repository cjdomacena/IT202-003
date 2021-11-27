<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();
$total = 0;
if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}
if (isset($_POST["quantity"]) && isset($_POST["cart"]) && !isset($_POST["type"])) {
	$id = get_user_id();
	$db = getDB();
	$qty = $_POST["quantity"];
	$cartID = $_POST["cart"];
	echo $qty;
	$stmt = $db->prepare("UPDATE Cart SET quantity = :q WHERE id = :cart_id");
	try {
		$stmt->execute([":q" => $qty, ":cart_id" => $cartID]);
		flash("Successfully Updated", "bg-green-200", 1000, "fade");
	} catch (PDOException $e) {
		flash("Something Went wrong...", "bg-red-200", 1000, "fade");
	}
	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		json_encode($r);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
} else if (isset($_POST["cart"]) && isset($_POST["type"])) {
	$db = getDB();
	$cartID = $_POST["cart"];
	$stmt = $db->prepare('DELETE FROM Cart WHERE id = :cart_id');
	try {
		$stmt->execute([":cart_id" => $cartID]);
		flash("Successfully Removed from cart", "bg-red-200");
	} catch (PDOException $e) {
		flash("Something Went wrong...", "bg-red-200");
	}
	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		json_encode($r);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
} else {
	$id = get_user_id();
	$db = getDB();
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
		<div class="my-8 py-4 bg-gray-100 rounded border">
			<h1 class="ml-4">View Cart</h1>
		</div>
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
	</div>
	<div class="w-3/12 my-8 py-4 rounded">
		<h3 class="p-4">Total: $<?php echo $total ?></h3>
	</div>
</div>