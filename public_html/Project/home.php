<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<h1>Home</h1>
<?php
if (is_logged_in()) {
    // echo "Welcome home, " . get_username();
    //comment this out if you don't want to see the session variables
    flash("Wecome!" . get_username(), "bg-green-200");
} else {
    echo "Not logged in";
}
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>