<?php

require(__DIR__ . "/../../partials/nav.php"); ?>

<?php
//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"])) {
    //get the email key from $_POST, default to "" if not set, and return the value
    $email = se($_POST, "email", "", false);
    //same as above but for password
    $password = se($_POST, "password", "", false);
    //TODO 3: validate/use
    //$errors = [];
    $hasErrors = false;
    if (empty($email)) {
        //array_push($errors, "Email must be set");
        flash("Username or email must be set", "bg-red-200");
        $hasErrors = true;
    }
    //sanitize
    //$email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (str_contains($email, "@")) {
        $email = sanitize_email($email);
        //validate
        //if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!is_valid_email($email)) {
            //array_push($errors, "Invalid email address");
            flash("Invalid email address", "bg-red-200");

            $hasErrors = true;
        }
    } else {
        if (!preg_match('/^[a-z0-9_-]{3,30}$/i', $email)) {
            flash("Username must only be alphanumeric and can only contain - or _", "bg-red-200");
            $hasErrors = true;
        }
    }
    if (empty($password)) {
        //array_push($errors, "Password must be set");
        flash("Password must be set", "bg-red-200");
        $hasErrors = true;
    }
    if (strlen($password) < 8) {
        //array_push($errors, "Password must be 8 or more characters");
        flash("Password must be at least 8 characters", "bg-red-200");
        $hasErrors = true;
    }
    if ($hasErrors) {
        //Nothing to output here, flash will do it
        //can likely flip the if condition
        //echo "<pre>" . var_export($errors, true) . "</pre>";
    } else {
        //TODO 4
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, email, password from Users where email = :email or username = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        ///echo "Weclome $email";
                        $_SESSION["user"] = $user;
                        //lookup potential roles
                        $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                        JOIN UserRoles on Roles.id = UserRoles.role_id 
                        where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                        $stmt->execute([":user_id" => $user["id"]]);
                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all since we'll want multiple
                        //save roles or empty array
                        if ($roles) {
                            $_SESSION["user"]["roles"] = $roles; //at least 1 role
                        } else {
                            $_SESSION["user"]["roles"] = []; //no roles
                        }
                        die(header("Location: home.php"));
                    } else {
                        //echo "Invalid password";
                        flash("Invalid password", "bg-red-200");
                    }
                } else {
                    //echo "Invalid email";
                    flash("Email not found", "bg-red-200");
                }
            }
        } catch (Exception $e) {
            //echo "<pre>" . var_export($e, true) . "</pre>";
            flash(var_export($e, true), "bg-red-200");
        }
    }
}
?>
<div class="min-h-auto flex  justify-center py-12 px-4 sm:px-6 lg:px-8 flex-col items-center">
    <div class="mx-auto container grid place-items-center py-8 text-xl-900">
        <div class="flex">
            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="">
            <h1 class="text-2xl font-bold">Sign in to your accont</h1>
        </div>
    </div>
    <div class="max-w-md w-full space-y-8 p-4 bg-gray-100 rounded-md shadow">
        <form onsubmit="return validate(this)" method="POST" class="mt-4 space-y-8">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" placeholder="Email address or Username" />
                </div>

            </div>
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="pw">Password</label>
                    <input type="password" id="pw" name="password" required minlength="8" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm mt-2" />
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot your password?
                    </a>
                </div>
            </div>


            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" value="Login">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <!-- Heroicon name: solid/lock-closed -->
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Sign in
                </button>
            </div>
            <!-- <input type="submit" value="Login" /> -->
        </form>


    </div>
</div>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>
<script>
    function validate(form, e) {
        // Prevent multiple submits

        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        const email = form.email.value;
        const isEmail = email.includes("@") ? true : false;

        if (email.length < 8 && isEmail) {
            flash("Invalid Credentials ", "bg-red-200");
            return false;
        }

    }
</script>