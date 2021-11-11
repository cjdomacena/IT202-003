<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<h1>Home</h1>
<?php
if (is_logged_in()) {
    $roles = get_role();
    flash("Wecome! " . get_username(), "bg-green-200");
    // Display roles
    if ($roles) {
        array_map(function ($role) {
            echo "Roles: <br/>";
            echo $role["name"] . "<br/>";
        }, $roles);
    }
} else {
    echo "Not logged in";
}
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>