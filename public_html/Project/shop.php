<?php
require(__DIR__ . "/../../partials/nav.php");

$categories = null;
$roles = get_role();

if (!is_logged_in() || !has_role("seller")) {
    redirect("index.php");
} else {
    $db = getDB();
    $stmt = $db->prepare("SELECT DISTINCT category FROM Products");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT COUNT(*) as count FROM Products WHERE user_id = :uid');
    try {
        $stmt->execute([':uid' => get_user_id()]);
        $r = $stmt->fetch();
    } catch (PDOException $e) {
        flash('Something went wrong...' . var_export($e), 'bg-red-200');
    }
    if ($r) {
        $total_pages = ceil($r['count'] / 4);
    } else {
        $total_pages = 1;
    }
    if (!isset($_GET['page'])) {
        $current_page = 1;
    } else {
        $current_page = se($_GET, 'page', 1, false);
    }
}

?>

<div class="container mx-auto my-16">
    <div class="flex justify-between">
        <h1 class="underline capitalize" id="filter_title">All Products</h1>
        <div class="flex items-center space-x-2">
            <div class="relative mr-3 md:mr-0 hidden md:block">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="shop_search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." name="shop_search" onkeydown="home_filter()">
            </div>
            <select class="rounded" id="shop_sort" name="shop_sort" onchange="home_filter()">
                <option value="">Sort</option>
                <option value="filter_by_name">Name (A-Z)</option>
                <option value="filter_by_price_asc">Price (Low to High)</option>
                <option value="filter_by_price_desc">Price (High to Low)</option>
                <option value="filter_by_rating_asc">Rating (Low to High)</option>
                <option value="filter_by_rating_desc">Rating (High to Low)</option>
                <option value="filter_by_stock">Out of stock only</option>
            </select>
            <select class="rounded" id="shop_category" name="shop_category" onchange="home_filter()">
                <option value="">Category</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="filter_by_<?php echo strtolower(se($category, "category", "", false)) ?>"><?php se($category, "category", "", true) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="bg-gray-100 px-4 py-2 rounded text-sm" onclick="clearAllFilters()"> Clear All Filters </button>
        </div>
    </div>
    <div class="grid xl:grid-cols-4 lg:grid-cols:4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mx-auto gap-4 m-4 w-full" id="card-skeleton">
        <div class="border shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex min-h-56 flex-col">
                <div class="rounded-t-lg object-cover h-64 w-full bg-gray-100 h-10 w-10"></div>
                <div class="flex-1 space-y-6">
                    <div class="h-2 bg-gray-100 rounded"></div>
                    <div class="space-y-3">
                        <div class="h-2 bg-gray-100 rounded col-span-2"></div>
                        <div class="h-2 bg-gray-100 rounded w-4/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-3/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-2/5"></div>
                        <div class="flex flex-row space-x-2">
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex min-h-56 flex-col">
                <div class="rounded-t-lg object-cover h-64 w-full bg-gray-100 h-10 w-10"></div>
                <div class="flex-1 space-y-6">
                    <div class="h-2 bg-gray-100 rounded"></div>
                    <div class="space-y-3">
                        <div class="h-2 bg-gray-100 rounded col-span-2"></div>
                        <div class="h-2 bg-gray-100 rounded w-4/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-3/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-2/5"></div>
                        <div class="flex flex-row space-x-2">
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex min-h-56 flex-col">
                <div class="rounded-t-lg object-cover h-64 w-full bg-gray-100 h-10 w-10"></div>
                <div class="flex-1 space-y-6">
                    <div class="h-2 bg-gray-100 rounded"></div>
                    <div class="space-y-3">
                        <div class="h-2 bg-gray-100 rounded col-span-2"></div>
                        <div class="h-2 bg-gray-100 rounded w-4/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-3/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-2/5"></div>
                        <div class="flex flex-row space-x-2">
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex min-h-56 flex-col">
                <div class="rounded-t-lg object-cover h-64 w-full bg-gray-100 h-10 w-10"></div>
                <div class="flex-1 space-y-6">
                    <div class="h-2 bg-gray-100 rounded"></div>
                    <div class="space-y-3">
                        <div class="h-2 bg-gray-100 rounded col-span-2"></div>
                        <div class="h-2 bg-gray-100 rounded w-4/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-3/5"></div>
                        <div class="h-2 bg-gray-100 rounded w-2/5"></div>
                        <div class="flex flex-row space-x-2">
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                            <div class="h-2 bg-gray-100 rounded w-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="userItems">

    </div>
    <input value="<?php se($current_page) ?>" class="hidden" id="page" />
    <?php require('./utils/pagination.php') ?>
</div>

<div class="my-4 container mx-auto">
    <a href="./products/add_product.php" class="p-4 bg-indigo-400 rounded hover:bg-indigo-200">Add New Product</a>
</div>
<script>
    get_cart_count();
    clearAllFilters();
    const page = document.getElementById('page').value;
    $(document).ready(
        $.ajax({
            type: "GET",
            url: "./products/user_products.php",
            data: {
                sort: "all_products",
                page: page,
            },
            success: (data) => {
                $("#userItems").html(data);
            }
        })
    )

    function home_filter() {
        const sort = document.getElementById("shop_sort").value;
        const category = document.getElementById("shop_category").value;
        const q = document.getElementById("shop_search").value;
        $.ajax({
            type: 'GET',
            url: "./products/user_products.php",
            data: {
                sort: sort,
                category: category,
                search: q,
            },
            success: (data) => {
                $("#userItems").html(data);
            }
        })
    }

    function clearAllFilters() {
        const sort = document.getElementById("shop_sort");
        const category = document.getElementById("shop_category");
        const q = document.getElementById("shop_search");
        sort.value = "";
        category.value = ""
        q.value = ""
        $.ajax({
            type: "GET",
            url: "./products/user_products.php",
            data: {
                sort: "all_products",
            },
            beforeSend: () => {
                document.getElementById('card-skeleton').classList.remove('hidden')
            },
            success: (data) => {
                $("#userItems").html(data);
            }
        }).done(() => {
            document.getElementById('card-skeleton').classList.add('hidden')
        })
    }
</script>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>

<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>