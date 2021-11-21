<?php
require_once("./../../../lib/functions.php");
session_start();
if(is_logged_in())
{	$r = ["message" => "Something went wrong...", "status" => 400];
	if (isset($_POST["product_id"])) {
		$user_id = get_user_id();
		$product_id = (int)$_POST["product_id"];
		$db = getDB();
		$stmt = $db->prepare("INSERT INTO Cart (product_id, user_id) VALUES (:product_id,:user_id)");
		try {
			$stmt->execute([":user_id" => $user_id, ":product_id" => $product_id]);
			$r["message"] = "Successfully added to cart!";
			$r["status"] = 200;
		} catch (PDOException $e) {
			// flash(var_export($e->errorInfo,true), "bg-red-200");
			$r["message"] = get_user_id();
			$r["status"] = 400;
		}
	}

	echo json_encode($r);
}
else {
	die(header("Location: /../.././login.php"));
}