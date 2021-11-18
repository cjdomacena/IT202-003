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
$products = [];
$db = getDB();
$stmt = $db->prepare("SELECT * FROM Products LIMIT 10");
try {
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    flash($e, "bg-red-200");
}

?>

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

    <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4" id="card-container">
        <?php foreach ($products as $index => $product) : ?>

            <div class="bg-white shadow-md border border-gray-200 rounded-lg max-w-sm">
                <a href="#">
                    <img class="rounded-t-lg object-cover h-64 w-full" src="<?php echo $product['image'] ?>" alt="" />
                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="text-gray-900 font-bold text-2xl tracking-tight mb-2"><?php echo $product['name'] ?></h5>
                    </a>
                    <p class="font-normal text-gray-700 mb-3"><?php echo $product['description'] ?></p>
                    <a href="#" class="text-indigo-800 font-medium text-sm py-2 text-center inline-flex items-center mt-4">
                        Add to Cart
                    </a>
                    <a href="<?php echo get_url('./products/view_product.php') ?>?id=<?php echo se($product, 'id');?>" class="text-indigo-800 font-medium text-sm py-2 text-center inline-flex items-center mt-4 ml-4">
                        View Product
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>


<?php
require(__DIR__ . "/../../partials/flash.php");
?>