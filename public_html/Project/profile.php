<?php
require_once(__DIR__ . "/../../partials/nav.php");
if (!is_logged_in()) {
    redirect("login.php");
}
?>
<?php
$email = get_user_email();
$username = get_username();
?>

<?php
if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);

    $params = [":email" => $email, ":username" => $username, ":id" => get_user_id()];
    // $password = se($_POST, "currentPassword", "", false);
    $db = getDB();

    $stmt = $db->prepare("UPDATE Users set email = :email, username = :username where id = :id");
    $hasError = false;
    $email = sanitize_email($email);
    if (!is_valid_email($email)) {
        flash("Invalid email", "bg-red-200");
        $hasError = true;
    }
    if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $username)) {
        flash("Username must only be alphanumeric and can only contain - or _", "bg-red-200");
        $hasError = true;
    }
    if (strlen($username) < 3) {
        flash("Username must be 3 or more characters", "bg-red-200");
        $hasError = true;
    }
    if (!$hasError) {
        try {
            $stmt->execute($params);
            flash("User profile successfully updated", "bg-green-200", "fade");
        } catch (Exception $e) {
            if ($e->errorInfo[1] === 1062) {
                //https://www.php.net/manual/en/function.preg-match.php
                // Error message contains / Users.columnName/
                // This pregmath will take the Users.columnName
                preg_match("/Users.(\w+)/", $e->errorInfo[2], $matches);
                if (isset($matches[1])) {
                    flash("The chosen " . $matches[1] . " is not available.", "bg-red-200");
                } else {
                    //TODO come up with a nice error message
                    flash("Something went wrong...", "bg-red-200");
                    echo "<pre>" . var_export($e->errorInfo, true) . "Wzzap</pre>";
                }
            } else {
                //TODO come up with a nice error message
                echo "<pre>" . var_export($e->errorInfo, true) . "Wazasd123</pre>";
            }
        }
    }
    //select fresh data from table
    $stmt = $db->prepare("SELECT id, email, IFNULL(username, email) as `username` from Users where id = :id LIMIT 1");
    try {
        $stmt->execute([":id" => get_user_id()]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            //$_SESSION["user"] = $user;
            $_SESSION["user"]["email"] = $user["email"];
            $_SESSION["user"]["username"] = $user["username"];
        } else {
            flash("User doesn't exist", "danger");
        }
    } catch (Exception $e) {
        flash("An unexpected error occurred, please try again", "danger");
        //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
    }
}
?>


<div class="w-1/2 mx-auto p-4 mt-4">
    <div class="my-4 space-y-4 p-4 bg-yellow-300">
        <h1 class="text-xl ">View Profile</h1>
    </div>
    <form method="POST" onsubmit="return validate(this);">
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php se($email); ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
        </div>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php se($username); ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
        </div>


        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" value="save" name="save">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <!-- Heroicon name: solid/lock-closed -->
                <svg class="h-5 w-5 text-gray-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            </span>
            Update Profile
        </button>

    </form>
</div>


<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>

<script>
    function validate(form) {
        const em = form.email.value;
        const uname = form.username.value;
        const errors = validateUser(em, uname)
        if (errors.length > 0) {
            errors.map((error) => {
                flash(error, "bg-red-200", 2000, "fade");
            })
            return false;
        } else {
            return true;
        }
    }
</script>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>