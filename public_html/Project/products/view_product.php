<?php
require(__DIR__ . "/../../../partials/nav.php");

$product = [];
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
// id, user_id, name, description, stock, cost, image
?>



<div class="container mx-auto my-4 px-4 mt-8">
	<div class="flex space-x-4 h-auto justify-center">
		<div class="w-3/5 flex justify-center">
			<img src="<?php echo $product["image"] ?>" alt="<?php echo $product["name"] ?>" class="rounded object-fit h-full w-4/5" />
		</div>
		<div class="w-2/5">
			<h1 class="text-4xl font-medium"><?php echo $product["name"] ?></h1>
			<div class="mt-2">
				<span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"><?php se($product, 'category') ?></span>
			</div>
			<p class="my-4 text-sm"><?php echo $product["description"] ?></p>
			<p class="my-4 text-sm">Available Stock: <?php echo $product["stock"] ?></p>
			<p class="my-4 text-lg font-medium">USD $<?php echo $product["cost"] ?></p>
			<div class="w-64 flex space-x-4 items-center">
				<label for="quantity" class="text-sm">Qty</label>
				<input type="number" min=1 max=99 value="1" name="quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 my-4 w-24" />
			</div>
			<button class="text-indigo-800 font-medium text-sm py-2 text-center inline-flex items-center mt-4" id="<?php echo $product["id"]; ?>" onclick="product_page_add_to_cart(this)">
				Add to Cart
			</button>
		</div>
	</div>

</div>
<script>
	$(document).ready(
		product_page_get_cart_count()
	)

	function product_page_add_to_cart(e) {
		const product_id = e.id
		const qty = document.getElementById("quantity").value;;
		$.post("./../cart/add_to_cart.php", {
			product_id: product_id,
			quantity: qty,
		}, (res) => {
			const data = JSON.parse(res);
			const {
				message,
				status
			} = data
			if (status === 200) {
				product_page_get_cart_count();
				window.scrollTo(0, 0);
				flash(message, "bg-green-200", 1000, "fade");
			}
		})
	}

	function product_page_get_cart_count() {
		$.get("./../products/get_cart_count.php", (res) => {
			let data = JSON.parse(res);
			const {
				message,
				status,
				logged_in
			} = data
			if (logged_in) {
				if (status === 200) {
					product_page_change_cart_counter(message);
				} else {
					flash(message, "bg-red-200", 1000, "fade");
				}
			}
		})
	}

	function product_page_change_cart_counter(message) {
		const cart = document.getElementById("cart-count");
		cart.innerText = message.count
	}
</script>
<?php
require(__DIR__ . "../../../../partials/flash.php");
?>