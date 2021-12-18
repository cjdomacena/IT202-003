<?php
//note we need to go up 1 more directory
require(__DIR__ . "/../../../partials/nav.php");

if (!has_role("admin")) {
    flash("You don't have permission to view this page", "warning");
    redirect(get_url('index.php'));
}
//handle the toggle first so select pulls fresh data
if (isset($_POST["role_id"])) {
    $role_id = se($_POST, "role_id", "", false);
    if (!empty($role_id)) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE Roles SET is_active = !is_active WHERE id = :rid");
        try {
            $stmt->execute([":rid" => $role_id]);
            flash("Updated Role", "bg-green-200");
        } catch (PDOException $e) {
            flash(var_export($e->errorInfo, true), "bg-red-200");
        }
    }
}
$query = "SELECT id, name, description, is_active from Roles";
$params = null;
if (isset($_POST["role"])) {
    $search = se($_POST, "role", "", false);
    $query .= " WHERE name LIKE :role";
    $params =  [":role" => "%$search%"];
}
$query .= " ORDER BY modified LIMIT 10";
$db = getDB();
$stmt = $db->prepare($query);
$roles = [];
try {
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        $roles = $results;
    } else {
        flash("No matches found", "bg-red-200");
    }
} catch (PDOException $e) {
    flash(var_export($e->errorInfo, true), "bg-red-200");
}

?>
<div class="container mx-auto p-4 bg-gray-100">

    <div class="mt-4">
        <div>
            <form method="POST">
                <div class="flex items-center w-auto justify-between">
                    <div>
                        <h1 class="text-xl">List Roles</h1>
                    </div>
                    <div class="flex">
                        <input type="search" name="role" placeholder="Role Filter" class="appearance-none rounded-none relative block w-48 p-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
                        <input type="submit" value="Search" class="ml-4 bg-indigo-600 mt-2 px-2 py-1 text-gray-100 rounded hover:bg-indigo-400" />
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-white rounded shadow">
            <table class="table-fixed border-collapse min-w-full rounded">
                <thead class="text-left bg-gray-200">
                    <th class="p-2">ID</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Description</th>
                    <th class="p-2 w-48">Status</th>
                    <th class="p-2 w-48">Action</th>
                </thead>
                <tbody>
                    <?php if (empty($roles)) : ?>
                        <tr>
                            <td class="w-full border border-gray-600">No roles</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($roles as $role) : ?>
                            <tr class="py-4 ">
                                <td class="  p-2"><?php se($role, "id"); ?></td>
                                <td class="  p-2"><?php se($role, "name"); ?></td>
                                <td class="  p-2"><?php se($role, "description"); ?></td>
                                <td class="  p-2">
                                    <span class="px-2 py-1 font-semibold leading-tight <?php echo (se($role, "is_active", 0, false) ? "bg-green-100" : "bg-red-100 ") ?> rounded-sm text-sm"><?php echo (se($role, "is_active", 0, false) ? "Active" : "Disabled"); ?></span>
                                </td>
                                <td class=" ">
                                    <form method="POST" class="p-2 m-0">
                                        <input type="hidden" name="role_id" value="<?php se($role, 'id'); ?>" />
                                        <?php if (isset($search) && !empty($search)) : ?>
                                            <?php /* if this is part of a search, lets persist the search criteria so it reloads correctly*/ ?>
                                            <input type="hidden" name="role" value="<?php se($search, null); ?>" />
                                        <?php endif; ?>
                                        <button type="submit" value="Toggle" class="py-2 px-4 bg-indigo-600 rounded text-gray-100 hover:bg-indigo-400">Toggle</button>
                                        <!-- <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                            <input type="checkbox" name="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div> -->
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
//note we need to go up 1 more directory
require_once(__DIR__ . "/../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>