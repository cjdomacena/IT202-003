<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();

if (!is_logged_in()) {
	redirect(get_url('index.php'));
}

if (isset($_POST["name"])) {
	$r = ["message" => "Something went wrong...", "status" => 400];
	$name = se($_POST, "name", "", false);
	$desc = se($_POST, "desc", "", false);
	$cost = se($_POST, "cost", -1, false);
	$stock = se($_POST, "stock", -1, false);
	$category = se($_POST, "category", -1, false);
	$isVisible = se($_POST, "visibility", false, false);
	$product_id = se($_POST,"product_id", -1, false);
	// $imageURL = se($_POST, "imageURL", "", false);
	$uid = get_user_id();
	$visibility = 0;
	if ($isVisible == false) {
		$visibility = 0;
	} else if ($isVisible == true) {
		$visibility = 1;
	}


	if ($cost == -1 || $stock == -1 || $category == -1) {
		flash("Something went wrong...", "bg-red-200");
	} else {
		$db = getDB();
		$stmt = $db->prepare("UPDATE Products SET name = :name, description = :desc, cost = :cost, stock = :stock, category = :category, visibility = :visibility WHERE id = :pid");
		try {
			// $stmt->execute([":name" => $name,  ":desc" => $desc, ":cost" => $cost, ":stock" => $stock, ":category" => $category, ":visibility" => $visibility, ":pid" => $product_id]);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
			$stmt->bindParam(':cost', $cost, PDO::PARAM_INT);
			$stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
			$stmt->bindParam(':category', $category, PDO::PARAM_STR);
			$stmt->bindParam(':visibility', $visibility, PDO::PARAM_BOOL);
			$stmt->bindParam(':pid', $product_id, PDO::PARAM_INT);
			$stmt->execute();
			flash("Product Successfully Added!", "bg-green-200");
		} catch (PDOException $e) {
			flash($e, "bg-red-200");
		}
	}
}
