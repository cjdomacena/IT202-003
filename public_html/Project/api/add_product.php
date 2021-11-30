<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();

if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}

if (isset($_POST["name"])) {
	$r = ["message" => "Something went wrong...", "status" => 400];
	$name = se($_POST, "name", "", false);
	$desc = se($_POST, "desc", "", false);
	$cost = se($_POST, "cost", -1, false);
	$stock = se($_POST, "stock", -1, false);
	$category = se($_POST, "category", -1, false);
	$isVisible = se($_POST, "visibility", 0, false);
	$imageURL = se($_POST, "imageURL", "", false);
	$uid = get_user_id();
	$visibility = 0;
	if($isVisible == false)
	{
		$visibility = 0;
	}
	else if($isVisible == true){
		$visibility = 1;
	}


	if ($cost == -1 || $stock == -1 || $category == -1) {
		flash("Something went wrong...", "bg-red-200");
	} else {
		$db = getDB();
		$stmt = $db->prepare("INSERT INTO Products (user_id, name, image, description,cost,stock,category, visibility) VALUES(:uid, :name, :image, :desc, :cost, :stock, :category, :visibility)");
		try {
			$stmt->execute([":uid" => $uid, ":name" => $name, ":image" => $imageURL, ":desc" => $desc, ":cost" => $cost, ":stock" => $stock, ":category" => $category, ":visibility" => $visibility]);
			flash("Product Successfully Added!", "bg-green-200");
		} catch (PDOException $e) {
			flash($e, "bg-red-200");
		}
	}
}


