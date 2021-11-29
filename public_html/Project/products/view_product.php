<?php
require(__DIR__ . "/../../../partials/nav.php");

$product = [];
if(isset($_GET["id"]))
{
	$id = se($_GET,"id", -1, false);
	if($id != -1)
	{
		$db = getDB();
		$stmt = $db->prepare('SELECT * FROM Products WHERE id = :id');
		$stmt->execute([':id' => $id]);
		$product = $stmt->fetch(PDO::FETCH_ASSOC);
	}

}

echo '<pre>' . var_export($product) . '</pre>';
?>


