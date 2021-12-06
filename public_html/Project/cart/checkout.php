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
	$r = [];

	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
		json_encode($r);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
	if ($r) {
		foreach ($r as $index => $item) {
			$total += $item["cost"] * $item["quantity"];
		}
	}
	$type = se($_POST, "type", "", false);
	if ($type == "checkout") {

		$fName = se($_POST, "fName", "", false);
		$lName = se($_POST, "lName", "", false);
		$address = se($_POST, "address", "", false);
		$total = se($_POST, "total", -1, false);
		$paymentMethod = se($_POST, "paymentMethod", "", false);
		$stmt = $db->prepare('INSERT INTO Orders(user_id,fName,lName,total_price,address,payment_method) VALUES(:user_id,:fName,:lName,:total_price,:address,:paymentMethod)');
		try {
			$stmt->execute([":user_id" => $id, ":fName" => $fName, ":lName" => $lName, ":total_price" => $total, ":address" => $address, ":paymentMethod" => $paymentMethod]);
			$order_id = $db->lastInsertId();
		} catch (PDOException $e) {
			flash("<pre>" . $e . "</pre>", "bg-red-200");
		}
		$hasError = 0;
		$errors = [];
		foreach ($r as $index => $item) {
			// cost, quantity, image, description, cart_id, id (product_id)
			$stmt = $db->prepare("INSERT INTO OrderItems (order_id,product_id, quantity) VALUES(:order_id,:product_id, :quantity)");
			try {
				$stmt->execute([":order_id" => $order_id, ":product_id" => $item['id'], ":quantity" => $item['quantity']]);
			} catch (PDOException $e) {
				$hasError++;
				array_push($errors, $e);
			}
		}
		if ($hasError > 0) {
			foreach ($errors as $error) {
				flash($error, "bg-red-200");
			}
		} else {
			flash("Purchase Successful!", "bg-red-200");
		}
	}
} else { // First load
	$db = getDB();
	$id = get_user_id();
	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
	if ($r) {
		foreach ($r as $index => $item) {
			$total += $item["cost"] * $item["quantity"];
		}
	}
}

?>
<script>
	const states = async () => {
		let res = await fetch("utils/us_states.json");
		res = await res.json();
		const selectInput = document.getElementById("state");
		await res.map((state) => {
			const option = document.createElement("option");
			option.value = state.name;
			option.innerHTML = state.name;
			selectInput.appendChild(option);
		})
		console.log(res);
	}
	states();
</script>
<div class="flex space-x-4 justify-between">
	<div class="w-8/12 mx-auto">
		<div class="my-8 py-4 rounded border">
			<h1 class="ml-4 text-xl">Checkout</h1>
			<p class="ml-4 text-sm">Shipping only available within the United States.</p>
		</div>

		<form onsubmit="checkout(); return false;">
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
			<div class="mb-6">
				<label for="address" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Shipping Address</label>
				<input type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1123 Moe St. Blvd." required>
			</div>
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
				<label for="state" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-400">State</label>
				<select id="state" size="1" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="getState()">

				</select>
			</div>
			<div class="mb-6">
				<label for="zipcode" class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300">Zipcode</label>
				<input type="text" id="zipcode" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="12345 or 12345-1234" required min=5>
			</div>
			<div class="mb-6">
				<input type="number" value="<?php echo $total ?>" class="invisible h-0 w-0" id="total" />
				<h3>Total: $<?php echo $total ?></h3>
				<p> Product Count: <?php echo count($r) ?> </p>
			</div>
			<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
		</form>
	</div>

</div>

<script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>