<?php
require_once("./../../../lib/functions.php");
	if(isset($_GET["products"]))
	{
		$products = [];
		$db = getDB();
		$stmt = $db->prepare("SELECT * FROM Products LIMIT 10");
		$stmt->execute();
		$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($products);
	}

	
?>