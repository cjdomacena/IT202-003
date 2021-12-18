<?php
require_once(__DIR__ . "../../../../lib/functions.php");
require_once(__DIR__ . "../../../../lib/db.php");
session_start();

$db = getDB();

$product_id = se($_GET, 'product_id', -1, false);

$limit = 5;
$stmt = $db->prepare('SELECT * FROM Ratings WHERE product_id = :product_id');
try {
	$stmt->execute([':product_id' => $product_id]);
	$s = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$row_count = $stmt->rowCount();
} catch (PDOException $e) {
	flash($e, 'bg-red-200');
}


if ($row_count >= 5) {
	$limit = 5;
}else {
	$limit = $row_count;
}


$r = [];
$params = [];
$q = "SELECT * FROM Ratings WHERE product_id = :product_id";
if (isset($_GET['type'])) {
	$type = se($_GET, 'type', 'id', false);
	switch ($type) {
		case 'date':
			$q .= ' ORDER BY created ';
			break;
		case 'ratings':
			$q .= ' ORDER BY rating ';
			break;
		default:
			$q .= ' ORDER BY id';
			break;
	}
}

if (isset($_GET['direction'])) {
	$direction = se($_GET, 'direction', 'asc', false);
	switch ($direction) {
		case 'asc':
			$q .= ' ASC';
			break;
		case 'desc':
			$q .= ' DESC';
			break;
		default:
			$q .= ' ASC';
			break;
	}

}

$page = se($_GET, 'page', 1, false);


$q .= " LIMIT :limit OFFSET :offset";
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmt = $db->prepare($q);
$offset = ($page - 1) * 5;
try {
	$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	$stmt->execute();
	$r = $stmt->fetchAll(PDO::FETCH_ASSOC);

	
} catch (PDOException $e) {
	flash($e, 'bg-red-200');
}
;
?>

<?php if ($r) : ?>
	<div class="space-y-4">
		<?php foreach ($r as $review) : ?>
			<div class="p-4 bg-gray-100 rounded space-y-2">
				<ul class="flex space-x-1">
					<?php for ($i = 0; $i < 5; $i++) : ?>
						<?php if ($i > se($review, 'rating', -1, false) - 1) : ?>
							<li><svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="1">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
						<?php else : ?>
							<li><svg class="w-6 h-6 fill-current text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="1">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
						<?php endif; ?>
					<?php endfor; ?>
				</ul>
				<p class="text-sm text-gray-600"><?php echo date('D M j\,\ Y G:i:s', strtotime(se($review, 'created', '', false))) ?></p>
				<p><?php se($review, 'comment') ?></p>
				<p class="text-sm"><?php se($review, 'username') ?></p>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>