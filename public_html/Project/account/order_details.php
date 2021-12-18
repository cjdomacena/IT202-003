<?php
require_once(__DIR__ . "/../../../partials/nav.php");
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}
if(isset($_GET["order_id"])){
	$db = getDB();
	$uid = get_user_id();
	$order_id = se($_GET, "order_id",-1, false);
	$orders = null;
	if($order_id == -1){
		flash("Something went wrong....", "bg-red-200");
	}
	$stmt = $db->prepare('SELECT * FROM Orders WHERE user_id = :uid ORDER BY created DESC LIMIT 10');
	try {
		$stmt->execute([":uid" => $uid]);
		$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		flash($e, "bg-red-200");
	}
}
else{
	redirect(get_url('index.php'));
}


?>