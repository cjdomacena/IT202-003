<?php
require_once(__DIR__ . '/../../partials/nav.php')
?>

<div class="container mx-auto my-16">
	<div id="data">

	</div>
</div>


<script>
	$(document).ready(
		$.ajax({
			type: "GET",
			url: "./cart/view_cart.php",
			success: (data) => {
				$("#data").html(data)
			}
		})
	)
</script>



<?php
require(__DIR__ . "/../../partials/flash.php");
?>