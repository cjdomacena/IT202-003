<?php
if (!is_logged_in()) {
	die(header("Location: " . get_url('index.php')));
}

?>


