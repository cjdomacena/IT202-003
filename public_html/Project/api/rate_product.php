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
	$db = getDB();
	$uid = get_user_id();
	$product_id = se($_POST, "product_id", -1, false);
	$rating = se($_POST, 'rate', -1, false);
	$comment = se($_POST, 'comment', "", false);
	$message = ["message" => "Some message", "status" => 404];
	$stmt = $db->prepare('INSERT INTO Ratings (product_id,user_id,rating, comment) VALUES (:product_id, :uid,:rating, :comment)');
	try {
		// $stmt->execute([":product_id" => $product_id, ":uid" => $uid, ":rating" => $rating, ':comment'=> $comment]);
		$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
		$stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
		$stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->execute();
		$message['message'] = "Comment added successfully!";
		$message['status'] = 200;
	} catch (PDOException $e) {
		$message['message'] = var_export($e);
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
	echo json_encode($message);
} else {
	redirect(get_url('index.php'));
}
