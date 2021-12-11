<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}
$total = 0;
// First load
$db = getDB();
$id = get_user_id();
$cart = [];
$products = [];
$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
try {
	$stmt->execute([":id" => $id]);
	$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	flash("Something went wrong...", "bg-red-200");
}
if ($cart) {
	foreach ($cart as $index => $item) {
		$total += $item["cost"] * $item["quantity"];
	}
}
// id = product_id
if (!empty($cart)) {
	$i = 0;
	while ($i < count($cart)) {
		$stmt = $db->prepare('SELECT cost, stock FROM Products WHERE id = :product_id');
		try {
			$stmt->execute([":product_id" => $cart[$i]["id"]]);
			$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
			array_push($products, $product);
		} catch (PDOException $e) {
			flash($e, "bg-red-200");
		}
		$i++;
	}
}


?>
<script>
	const states = async () => {
		let res = await fetch("../utils/us_states.json");
		res = await res.json();
		const selectInput = document.getElementById("state");
		await res.map((state) => {
			const option = document.createElement("option");
			option.value = state.name;
			option.innerHTML = state.name;
			selectInput.appendChild(option);
		})
	}
	states();
</script>
<div class="flex justify-between container">
	<div class="bg-indigo-900 w-screen h-screen absolute top-0 left-0 grid place-items-center hidden" id="loading">
		<div class="flex text-white">
			<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
				<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
			</svg>
			Processing...
		</div>
	</div>
	<div class="flex space-x-4 justify-between w-full">
		<div class="w-8/12 mx-auto">
			<div class="my-8 py-4 rounded border">
				<h1 class="ml-4 text-xl">Checkout</h1>
				<p class="ml-4 text-sm">Shipping only available within the United States.</p>
			</div>

			<form onsubmit="checkout(); return false">
				<h1 class="my-4 font-bold">Contact Information</h1>
				<div class="grid grid-cols-2 gap-4 w-full">
					<div class="mb-6">
						<label for="fName" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">First Name</label>
						<input type="text" id="fName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 w-full" placeholder="John" required>
					</div>
					<div class="mb-6">
						<label for="lName" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Last Name</label>
						<input type="text" id="lName" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 w-full" placeholder="Doe" required>
					</div>
				</div>
				<hr />
				<div class="mb-6 space-y-4">
					<h1 class="my-4 font-bold">Shipping Information</h1>
					<div>
						<label for="address" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Shipping Address</label>
						<input type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1123 Moe St. Blvd." required>
					</div>
					<div>
						<label for="apt" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Apt, Suite, etc.</label>
						<input type="text" id="apt" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Suite 2" required>
					</div>
				</div>
				<div class="grid grid-cols-2 gap-4 items-center">
					<div class="mb-6">
						<label for="state" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">State</label>
						<select id="state" size="1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="getState()">

						</select>
					</div>
					<div class="mb-6">
						<label for="zipcode" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Zipcode</label>
						<input type="text" id="zipcode" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="12345" required min=5>
					</div>
				</div>
				<hr />
				<h1 class="my-4 font-bold">Payment Information</h1>
				<div class="grid grid-cols-2 gap-4 items-center">
					<div class="mb-6">
						<label for="payment_method" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">Payment Method</label>
						<select id="payment_method" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="getPaymentMethod()">
							<option selected>Visa</option>
							<option>Mastercart</option>
							<option>AMEX</option>
							<option>Discover</option>
						</select>
					</div>
					<div class="mb-6">
						<label for="payment" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Payment Amount ($)</label>
						<input type="text" id="payment" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required min=5>
					</div>
				</div>

				<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
			</form>
		</div>
	</div>
	<aside class="w-2/5 h-auto mt-8 p-4">
		<div class="border h-auto p-4 w-full">
			<div class="flex justify-between">
				<h1>Cart</h1>
				<div class="flex">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
					</svg>
					<?php echo count($cart) ?>
				</div>
			</div>
			<div class="space-y-4 mt-4">
				<?php for ($i = 0; $i < count($cart); $i++) : ?>
					<div class="flex justify-between">
						<div>
							<h1 class="font-semibold"><?php echo $cart[$i]["name"] ?> </h1>
							<p class="text-sm">Original Price: $<?php echo $products[$i][0]["cost"] ?></p>
							<p class="text-sm">Available Stock: <?php echo ($products[$i][0]["stock"]) ?></p>
						</div>
						<div class="flex flex-col justify-evenly">
							<p> Subtotal: $<?php echo $cart[$i]["cost"] ?></p>
							<p class="text-sm"> x <?php echo $cart[$i]["quantity"] ?></p>
						</div>
					</div>

				<?php endfor; ?>
				<hr />
				<div class="flex justify-between font-bold">
					<input id="total" value="<?php echo $total ?>" class="hidden" />
					<p>Total:</p>
					<p>$ <?php echo $total ?></p>
				</div>
				<!--  -->
			</div>
	</aside>
</div>


<?php
require_once(__DIR__ . "../../../../partials/flash.php");
?>