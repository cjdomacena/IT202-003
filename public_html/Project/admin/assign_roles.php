<?php
//note we need to go up 1 more directory
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH" . "home.php"));
}



//attempt to apply
if (isset($_POST["users"]) && isset($_POST["roles"])) {
    $user_ids = $_POST["users"]; //se() doesn't like arrays so we'll just do this
    $role_ids = $_POST["roles"]; //se() doesn't like arrays so we'll just do this
    if (empty($user_ids) || empty($role_ids)) {
        flash("Both users and roles need to be selected", "warning");
    } else {
        //for sake of simplicity, this will be a tad inefficient
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO UserRoles (user_id, role_id, is_active) VALUES (:uid, :rid, 1) ON DUPLICATE KEY UPDATE is_active = !is_active");
        foreach ($user_ids as $uid) {
            foreach ($role_ids as $rid) {
                try {
                    $stmt->execute([":uid" => $uid, ":rid" => $rid]);
                    flash("Updated role", "bg-green-200");
                } catch (PDOException $e) {
                    flash(var_export($e->errorInfo, true), "bg-yellow-300");
                }
            }
        }
    }
}

//get active roles
$active_roles = [];
$db = getDB();
$stmt = $db->prepare("SELECT id, name, description FROM Roles WHERE is_active = 1 LIMIT 10");
try {
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        $active_roles = $results;
    }
} catch (PDOException $e) {
    flash(var_export($e->errorInfo, true), "danger");
}



//search for user by username
$users = [];
if (isset($_POST["username"])) {

    $username = se($_POST, "username", "", false);
    if (!empty($username)) {
        $db = getDB();
        $stmt = $db->prepare("SELECT Users.id, username, (SELECT GROUP_CONCAT(name, ' (' , IF(ur.is_active = 1,'active','inactive') , ')') from 
        UserRoles ur JOIN Roles on ur.role_id = Roles.id WHERE ur.user_id = Users.id) as roles
        from Users WHERE username like :username");
        try {
            $stmt->execute([":username" => "%$username%"]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($results) {
                $users = $results;
            }
        } catch (PDOException $e) {
            flash(var_export($e->errorInfo, true), "bg-red-200");
        }
    } else {
        flash("Username must not be empty", "bg-yellow-300");
    }
}


?>
<div class="w-1/2 mx-auto mt-8">
    <div class="my-4">
        <h1 class="text-xl">Assign Roles</h1>
    </div>
    <form method="POST">
        <div class="flex space-x-4">
            <div class="flex-1">
                <input type="search" name="username" placeholder="Username search" class="appearance-none rounded-none relative block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2 w-full" />
            </div>
            <div class="grid place-items-center mt-2">
                <button type="submit" class="group relative flex justify-center px-3 py-2  border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" value="Search" name="search">
                    Search
                </button>
            </div>

        </div>
    </form>

    <form method="POST">
        <?php if (isset($username) && !empty($username)) : ?>
            <input type="hidden" name="username" value="<?php se($username, false); ?>" />
        <?php endif; ?>
        <div class="flex space-x-4">
            <table class=" flex-1 table-fixed border-collapse rounded border">
                <thead class="text-left bg-gray-200">
                    <th class="p-2">Users</th>
                    <th class="p-2">Roles</th>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr class="py-4">
                            <td class="p-2">
                                <input id="user_<?php se($user, 'id'); ?>" type="checkbox" name="users[]" value="<?php se($user, 'id'); ?>" />
                                <label for="user_<?php se($user, 'id'); ?>"><?php se($user, "username"); ?></label>
                            </td>
                            <td class="p-2"><?php se($user, "roles", "No Roles"); ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table class="table-fixed border-collapse  rounded border">
                <thead class="text-left bg-gray-200">
                    <th class="p-2">Roles to Assign</th>
                </thead>
                <tbody>

                    <?php foreach ($active_roles as $role) : ?>
                        <tr>
                            <td class="p-2">
                                <div>
                                    <input id="role_<?php se($role, 'id'); ?>" type="checkbox" name="roles[]" value="<?php se($role, 'id'); ?>" />
                                    <label for="role_<?php se($role, 'id'); ?>"><?php se($role, "name"); ?></label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>
        <div class="mt-8 w-full flex justify-end">
            <button type="submit" class="group  relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-48" value="Toggle Roles">
                Toggle Roles
            </button>
        </div>
    </form>

</div>
<?php
//note we need to go up 1 more directory
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>