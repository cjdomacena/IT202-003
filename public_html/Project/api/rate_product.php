<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();
if (!is_logged_in()) {
	redirect(get_url('index.php'));
}

if (
	isset($_POST['comment'])
	&& isset($_POST['rate'])
	&& isset($_POST['product_id'])
) {
	$message = ["message" => "Some message", "status" => 404];
	$db = getDB();
	$uid = (int) get_user_id();
	$product_id = (int) se($_POST, "product_id", -1, false);
	$stmt = $db->prepare('SELECT user_id FROM Products WHERE id = :product_id');
	try {
		$stmt->execute([':product_id' => $product_id]);
		$puid = $stmt->fetch();
	} catch (PDOException $e) {
		$message['message'] = $e->errorInfo;
		$message['status'] = 404;
	}
	if ($puid['user_id'] == $uid) {
		$message['message'] = "Can't provide review on your own product!";
		$message['status'] = 500;
	} else {
		$username = get_username();
		
		$rating = se($_POST, 'rate', -1, false);
		$comment = se($_POST, 'comment', "", false);

		$stmt = $db->prepare('INSERT INTO Ratings (product_id,user_id,rating, comment, username) VALUES (:product_id, :uid,:rating, :comment, :username)');
		try {

			$stmt->execute([":product_id" => $product_id, ":uid" => $uid, "rating" => $rating, ":comment" => $comment, ":username" => $username]);
			$message['message'] = "Comment added successfully!";
			$message['status'] = 200;
		} catch (PDOException $e) {
			$message['message'] = $e->errorInfo;
			$message['status'] = 404;
		}
		if ($message['status'] == 200) {
			$stmt = $db->prepare('SELECT COUNT(rating) as rating_count, SUM(rating) as rating_sum FROM Ratings WHERE product_id = :product_id');
			try {
				$stmt->execute([":product_id" => $product_id]);
				$ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				$message['message'] = var_export($e);
				$message['status'] = 404;
			}
			$avg_rating = floatval(round($ratings[0]['rating_sum'] / $ratings[0]['rating_count'], 2));
			$stmt = $db->prepare('UPDATE Products SET avg_rating = :avg_rating WHERE id = :product_id');
			try {
				$stmt->bindParam(':avg_rating', $avg_rating, PDO::PARAM_INT);
				$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
				$stmt->execute();
			} catch (PDOException $e) {
				$message['message'] = var_export($e);
				$message['status'] = 404;
			}
		}
	}

	echo json_encode($message);
} else {
	redirect(get_url('index.php'));
}
