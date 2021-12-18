<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();

if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}else{
	$r = ["message" => "Something went wrong...", "status" => 400];
	$product_id = se($_POST, "product_id", -1, false);
	$db = getDB();
	$stmt = $db->prepare("DELETE FROM Products WHERE id = :pid");
	try {
		$stmt->bindParam(':pid', $product_id, PDO::PARAM_INT);
		$stmt->execute();
		flash("Product Successfully Removed!", "bg-green-200");
	} catch (PDOException $e) {
		flash($e, "bg-red-200");
	}
}

