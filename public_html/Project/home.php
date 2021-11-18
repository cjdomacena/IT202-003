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

<button onclick=req()>Test</button>
<div class="container mx-auto my-16">
    <div class="flex justify-between">
        <h1 class="text-underline">All Products</h1>
        <div>
            <label for="filter" class="invisible">Filter</label>
            <select class="p-2 rounded" id="filter" name="Sort">
                <option value="filter_all">All</option>
                <option value="filter_by_name">Name</option>
                <option value="filter_by_price_asc">Price (Low to High)</option>
                <option value="filter_by_price_desc">Price (High to Low)</option>
            </select>
        </div>
    </div>

    <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4">
        <div class="bg-white w-full h-72 rounded shadow">

        </div>
        <div class="bg-white w-full h-72 rounded shadow">

        </div>
        <div class="bg-white w-full h-72 rounded shadow">

        </div>
        <div class="bg-white w-full h-72 rounded shadow">

        </div>
    </div>
</div>

<script>
    const image = document.getElementById("image")
    let products;
    const req = async () => {
        try {
            const res = await fetch("./api/get_products.php?products=all", {
                method: "GET",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-Requested-With": "XMLHttpRequest",
                },
            })

            // res returns a promise so we need to await
            products = await res.json()
            console.log(products);
        } catch (e) {
            flash(`Something went wrong: ${e}`, "bg-red-200")
        }
    }
</script>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>