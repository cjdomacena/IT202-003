<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!is_logged_in() || has_role("default")) {
	die(header("Location: " . get_url("index.php")));
}

if (isset($_GET["order_id"])) {
	$order_id = se($_GET, "order_id", "", false);
	$db = getDB();

	


}

?>

<div class="container mx-auto h-24 bg-indigo-200 mt-8">
<h1>Order #<?php echo $order_id?></h1>

</div>


<?php
require_once(__DIR__ . "../../../../partials/flash.php");
?>