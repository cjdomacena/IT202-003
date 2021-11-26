<?php
require_once("./../../../lib/functions.php");
session_start();
if (is_logged_in()) {
	$r = ["message" => "Something went wrong...", "status" => 400];
	if (isset($_POST["product_id"])) {
		$uid = get_user_id();
		$pid = (int)$_POST["product_id"];
		$quantity = 1;
		$db = getDB();
		$stmt = $db->prepare("INSERT INTO Cart (product_id, user_id, quantity) VALUES (:pid,:uid, :q) ON DUPLICATE KEY UPDATE quantity = quantity + :q");
		try {
			$stmt->bindValue(":q", $quantity, PDO::PARAM_INT);
			$stmt->bindValue(":uid", $uid, PDO::PARAM_INT);
			$stmt->bindValue(":pid", $pid, PDO::PARAM_INT);
			$stmt->execute();
			$r["message"] = "Successfully added to cart!";
			$r["status"] = 200;
		} catch (PDOException $e) {
			// flash(var_export($e->errorInfo,true), "bg-red-200");
			$r["message"] = get_user_id();
			$r["status"] = 400;
		}
	}

	echo json_encode($r);
} else {
	die(header("Location: /../.././login.php"));
}
