<?php
require_once(__DIR__ . '/../../partials/nav.php');
if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}
?>

<div class="container mx-auto my-16">
	<div id="data-cart">

	</div>
</div>


<script>
	get_cart_count()
	$(document).ready(
		$.ajax({
			type: "GET",
			url: "./cart/view_cart.php",
			success: (data) => {
				$("#data-cart").html(data)
			}
		})
	)
</script>



<?php
require(__DIR__ . "/../../partials/flash.php");
?>