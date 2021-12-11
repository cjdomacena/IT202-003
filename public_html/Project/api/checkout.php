<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();
$total = 0;
if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}
// 
if (isset($_POST["type"])) {
	$db = getDB();
	$id = get_user_id();
	$type = se($_POST, "type", "", false);
	$user_cart = [];
	$errors = [];
	$stmt = $db->prepare('SELECT Cart.id as cart_id, Products.name, Products.description, Products.image, Products.cost,Products.id as product_id, Cart.quantity FROM((Products INNER JOIN Cart ON Products.id = Cart.product_id) INNER JOIN Users ON Users.id = :id)');
	try {
		$stmt->execute([":id" => $id]);
		$user_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash("Something went wrong...", "bg-red-200");
	}
	$message = [];
	if ($user_cart) {
		$i = 0;
		while ($i < count($user_cart)) {
			$stmt = $db->prepare('SELECT stock FROM Products WHERE id = :product_id');
			try {
				$stmt->execute([":product_id" => $user_cart[$i]["product_id"]]);
				$product_qty = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if ((int)$user_cart[$i]["quantity"] > (int)$product_qty[0]["stock"]) {
					$holdMessage = "Available stock for " . $user_cart[$i]["name"] . ": " . (int)$product_qty[0]["stock"] . ", Cart Qty: " . $user_cart[$i]["quantity"];
					array_push($message, $holdMessage);
				}
				$total += $user_cart[$i]["cost"] * $user_cart[$i]["quantity"];
			} catch (PDOException $e) {
				flash($e, "bg-red-200");
			}
			$i++;
		}
		if (count($message) <= 0) {
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
				while ($i < count($user_cart)) {
			
					$stmt = $db->prepare("INSERT INTO OrderItems (order_id,product_id, quantity, cost_on_purchase) VALUES(:order_id,:product_id, :quantity, :cost)");
					$purchase_cost = (int)$user_cart[$i]["cost"];
					try {
						$stmt->execute([":order_id" => $order_id, ":product_id" => $user_cart[$i]['product_id'], ":quantity" => $user_cart[$i]['quantity'], ":cost" => $purchase_cost]);
					} catch (PDOException $e) {
						$hasError++;
						array_push($errors, $e);
					}

					$stmt = $db->prepare("UPDATE Products SET stock = stock - :cart_qty WHERE id = :product_id");
					try {
						$stmt->bindValue(":cart_qty", $user_cart[$i]['quantity'], PDO::PARAM_INT);
						$stmt->bindValue(":product_id", $user_cart[$i]['product_id'], PDO::PARAM_INT);
						$stmt->execute();
					} catch (PDOException $e) {
						$hasError++;
						array_push($errors, $e);
					}

					$stmt = $db->prepare("DELETE FROM Cart WHERE id = :cart_id");
					try {
						$stmt->execute([":cart_id" => $user_cart[$i]["cart_id"]]);
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
		} else {
			echo json_encode(["order_id" => -1, "message" => $message]);
		}
	}
}
