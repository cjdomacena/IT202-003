<?php
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "/Project",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();
require_once(__DIR__ . "/../lib/functions.php");

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- include css and js files -->
<script src="<?php echo get_url("utils/index.js") ?>" defer></script>
<script src="<?php echo get_url('helper.js'); ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
<!-- Include the storage api -->
<script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-storage.js"></script>
<script src="<?php echo get_url('firebase.js'); ?>"></script>
<link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.min.css" />
<header class="w-full">
    <nav class="container-2xl bg-indigo-600 p-4 flex justify-between px-8 shadow">
        <div id="logo" class="h-8">
            <a href="<?php echo get_url('index.php'); ?>" class="text-gray-100 flex text-xl hover:text-gray-300 items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
                Basic Shop</a>
        </div>
        <ul class="list-none flex space-x-4 text text-gray-100 h-8 items-center ">
            <?php if (is_logged_in()) : ?>
                <li class="hover:text-indigo-200"><a href="<?php echo get_url('index.php'); ?>">Home</a></li>
                <li>
                    <?php if (has_role("seller") || has_role("admin")) : ?>
                <li class="hover:text-indigo-200"><a href="<?php echo get_url('shop.php'); ?>">My Shop</a>
                </li>
            <?php endif; ?>
            <li>
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="text-white hover:text-indigo-200 font-medium rounded-lg px-2 py-2.5 text-center inline-flex items-center" type="button">Account<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="hidden bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow w-44">
                    <ul class="py-1" aria-labelledby="dropdownButton">
                        <li>
                            <a href="<?php echo get_url('account/view_profile.php'); ?>" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2">View Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo get_url('profile.php'); ?>" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2">Edit Profile</a>
                        </li>
                        <?php if (has_role('shopper')) : ?>
                            <li class="hover:text-indigo-200">
                                <a class="text-sm hover:bg-gray-100 block px-4 py-2 text-gray-700" href="<?php echo get_url('account/purchase_history.php') ?>">Purchase History</a>
                            </li>
                        <?php endif ?>
                        <?php if (has_role('seller') || has_role('admin')) : ?>
                            <li class="hover:text-indigo-200">
                                <a class="text-sm hover:bg-gray-100 block px-4 py-2 text-gray-700" href="<?php echo get_url('admin/order_history.php') ?>">Order History</a>
                            </li>
                        <?php endif ?>
                        <li>
                            <a href="<?php echo get_url('account/reset_password.php'); ?>" class="text-sm hover:bg-gray-100 text-red-400 block px-4 py-2">Reset Password</a>
                        </li>

                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (!is_logged_in()) : ?>
            <li class="hover:text-indigo-200"><a href="<?php echo get_url('index.php'); ?>">Home</a></li>
            <li>
            <li class="hover:text-indigo-200"><a href="<?php echo get_url('login.php'); ?>">Login</a></li>
            <li class="hover:text-indigo-200"><a href="<?php echo get_url('register.php'); ?>">Register</a></li>
        <?php endif; ?>
        <?php if (has_role("admin")) : ?>
            <li>
                <button id="dropdownButton-role" data-dropdown-toggle="dropdown-role" class="text-white hover:text-indigo-200 font-medium rounded-lg pl-0 pr-2 py-2.5 text-center inline-flex items-center" type="button">Roles<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>
                <div id="dropdown-role" class="hidden bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow w-44">
                    <ul class="py-1" aria-labelledby="dropdownButton-role">
                        <li class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2"><a href="<?php echo get_url('admin/create_role.php'); ?>">Create Role</a></li>
                        <li class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2"><a href="<?php echo get_url('admin/list_roles.php'); ?>">List Roles</a></li>
                        <li class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2"><a href="<?php echo get_url('admin/assign_roles.php'); ?>">Assign Roles</a></li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <?php if (is_logged_in()) : ?>
            <li class="hover:text-indigo-200 text-red-500"><a href="<?php echo get_url('logout.php'); ?>">Logout</a></li>
            <li> | </li>
            <li class="capitalize">Role: <?php echo get_role()[0]["name"] == 'default' ? get_role()[1]["name"] : get_role()[0]["name"] ?></li>
        <?php endif; ?>
        <li class="border-l-2 pl-3 border-gray-900  border-opacity-25 hover:text-gray-400 text-white">
            <a href="<?php echo get_url('cart.php'); ?>" class="flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-sm font-medium inline-flex items-center p-1 rounded-full mr-2 w-4 h-4 text-center align-middle">
                    <?php if (is_logged_in()) : ?>
                        <p class="text-center mx-auto" id="cart-count" onload="get_cart_count()"></p>
                    <?php endif; ?>
                </span>
            </a>
        </li>
        </ul>
    </nav>
</header>