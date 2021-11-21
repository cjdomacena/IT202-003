 <?php
	require_once(__DIR__ . "../../../../lib/functions.php");
	require_once(__DIR__ . "../../../../lib/db.php");
	session_start();
	$r = ["message" => "Something went wrong...", "status" => 400];
	$result;
	if (is_logged_in()) {
		$db = getDB();
		$stmt = $db->prepare("SELECT COUNT(user_id) as count  FROM Cart WHERE user_id = :uid");
		$id = get_user_id();
		$stmt->execute([":uid" => $id]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$r["status"] = 200;
		$r["message"] = $result;
	} else {
		$r["message"] = "User must be logged in";
	}

	echo json_encode($r);
