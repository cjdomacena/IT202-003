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
		$zipcode = se($_POST, "zipcode", -1, false);
		$state = se($_POST, "state", "", false);
		$paymentMethod = se($_POST, "paymentMethod", "", false);
		$stmt = $db->prepare('INSERT INTO Orders(user_id,fName,lName,total_price,address,payment_method,zip,state) VALUES(:user_id,:fName,:lName,:total_price,:address,:paymentMethod, :zipcode,:state)');
		try {
			$stmt->execute([":user_id" => $id, ":fName" => $fName, ":lName" => $lName, ":total_price" => $total, ":address" => $address, ":paymentMethod" => $paymentMethod, ":zipcode" => $zipcode, ":state" => $state]);
			$order_id = $db->lastInsertId();
		} catch (PDOException $e) {
			flash("<pre>" . $e . "</pre>", "bg-red-200");
		}
		$hasError = 0;
		$errors = [];

		$i = 0;
		while ($i < count($r)) {
			// cost, quantity, image, description, cart_id, id (product_id)
			$stmt = $db->prepare("INSERT INTO OrderItems (order_id,product_id, quantity) VALUES(:order_id,:product_id, :quantity)");
			try {
				$stmt->execute([":order_id" => $order_id, ":product_id" => $r[$i]['id'], ":quantity" => $r[$i]['quantity']]);
			} catch (PDOException $e) {
				$hasError++;
				array_push($errors, $e);
			}
			$i++;
		}
		if ($hasError > 0) {
			foreach ($errors as $error) {
				flash($error, "bg-red-200");
			}
		} else {
			flash("Purchase Successful!", "bg-green-200");
			echo json_encode(["order_id" => $order_id]);
		}
	}
}
