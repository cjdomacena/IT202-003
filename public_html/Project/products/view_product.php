<?php
require(__DIR__ . "/../../../partials/nav.php");

$product = [];
if (isset($_GET["id"])) {
	$id = se($_GET, "id", -1, false);
	if ($id != -1) {
		$db = getDB();
		$product = "";
		$stmt = $db->prepare('SELECT * FROM Products WHERE id = :id');
		try {
			$stmt->execute([':id' => $id]);
			$product = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			flash("Something went wrong...", "bg-red-200");
		}
	}
	$stmt = $db->prepare('SELECT * FROM Ratings WHERE product_id = :id');
	try {
		$stmt->execute([':id' => $id]);
		$total_pages = ceil($stmt->rowCount() / 5);
	} catch (PDOException $e) {
		flash('Something went wrong...' . $e, 'bg-red-200');
	}
} else {
	redirect("index.php");
}
$current_page = se($_GET, 'page', 1, false);
?>
<div class="bg-indigo-900 w-screen h-screen fixed top-0 left-0 grid place-items-center hidden" id="loading">
	<div class="flex text-white">
		<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
			<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
			<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
		</svg>
		Processing...
	</div>
</div>
<div class="container mx-auto mt-8">
	<ul class="text-sm font-semibold my-2 flex space-x-2">
		<li class="text-gray-600"><a href="<?php echo get_url('index.php') ?>">Products</a></li>
		<li> / </li>
		<li> <?php echo $product["name"] ?> </li>
	</ul>
	<hr />
</div>

<div class="container mx-auto my-24 px-4 h-auto">
	<div class="flex space-x-4 h-auto justify-center">
		<div class="w-3/5 flex justify-center h-96">
			<img src="<?php echo $product["image"] ?>" alt="<?php echo $product["name"] ?>" class="rounded object-contain h-full w-4/5 " />
		</div>
		<div class="w-2/5">
			<h1 class="text-4xl font-medium"><?php echo $product["name"] ?></h1>
			<div class="mt-4">
				<span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800"><?php se($product, 'category') ?></span>
			</div>
			<details open class="my-4">
				<summary class="cursor-pointer">Description</summary>
				<p class="my-4 text-sm"><?php echo $product["description"] ?></p>
			</details>
			<p class="my-4 text-sm">Available Stock: <?php echo $product["stock"] ?></p>
			<p class="my-4 text-lg font-medium">USD $<?php echo $product["cost"] ?></p>
			<div class="w-64 flex space-x-4 items-center">
				<label for="quantity" class="text-sm">Qty</label>
				<input type="number" min=1 max=99 value="1" name="quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 my-4 w-24" />
			</div>
			<button class="text-indigo-800 font-medium text-sm py-2 text-center inline-flex items-center mt-4" id="<?php echo $product["id"]; ?>" onclick="product_page_add_to_cart(this)">
				Add to Cart
			</button>
			<input value="<?php se($id) ?>" id="product_id" class="hidden" />
		</div>
	</div>
	<hr class="mt-24" />
	<div class="flex mt-4 space-x-12">
		<div class="w-96">
			<div class="flex flex-col space-y-2 mt-4 w-full" id='ratings'>
				<div class="flex items-center justify-between">
					<div class="space-y-1">
						<label class="text-sm" for="rating">Rating: </label>
						<ul class="flex space-x-2">
							<li><svg class="w-6 h-6 text-indigo-400 rating" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="1">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
							<li><svg class="w-6 h-6  text-indigo-400 rating" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="2">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
							<li><svg class="w-6 h-6  text-indigo-400 rating" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="3">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
							<li><svg class="w-6 h-6  text-indigo-400 rating" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="4">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
							<li><svg class="w-6 h-6  text-indigo-400 rating" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-index="5">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
								</svg></li>
						</ul>
					</div>
					<button onclick="reset()" class="text-sm hover:bg-gray-200 text-gray-900 px-4 py-2 bg-gray-300">Reset</button>
				</div>
				<div>
					<?php if (is_logged_in()) : ?>
						<textarea rows="6" class="w-full rounded border border-indigo-400" id="comment" placeholder="Write a review"></textarea>
					<?php else : ?>
						<textarea rows="6" class="w-full rounded border border-gray-400 bg-gray-100 placeholder-gray-600" placeholder="Must be logged in to write a review" disabled></textarea>
					<?php endif; ?>
				</div>
				<div class="flex">
					<?php if (!is_logged_in()) : ?>
						<button class="py-2 px-4 rounded bg-indigo-400" disabled>Must be logged in</button>
					<?php else : ?>
						<button class="py-2 px-4 hover:bg-indigo-300 rounded bg-indigo-400" onclick=submitReview(event)>Submit</button>
					<?php endif ?>
				</div>
			</div>
		</div>

		<div class="w-4/5">
			<div class="flex items-center justify-between">
				<div class="my-4">
					<h3>Reviews: </h3>
					<div class="flex space-x-1 items-center">
						<p class="text-xs">Average rating: </p>
						<?php if ($product['avg_rating'] == 0) : ?>
							<span class="text-xs">Not available</span>
						<?php else : ?>

							<span class="text-xs"><b><?php se($product, 'avg_rating') ?></b> out of 5</span>
						<?php endif ?>

					</div>
				</div>
				<div class="space-x-4">
					<select class="rounded" id="direction" onchange="showReviews()">
						<option value="desc" default>High to Low</option>
						<option value="asc">Low to High</option>

					</select>
					<select class="rounded" id="type" onchange="showReviews()">
						<option value="ratings" default>Ratings</option>
						<option value="date">Date</option>

					</select>
					<button class="text-sm hover:bg-gray-200 text-gray-900 px-4 py-2 bg-gray-300" onclick="clearFilter()">Clear Filters</button>
				</div>
			</div>
			<div id="reviews" class="flex-auto">

			</div>
			<div class="p-4 bg-gray-100 rounded hidden" id="review-loading">
				<div class="animate-pulse space-y-2">
					<div class="h-2 bg-gray-300 rounded w-24"></div>
					<div class="h-2 bg-gray-300 rounded w-52"></div>
					<div class="h-2 bg-gray-300 rounded w-96"></div>
					<div class="h-2 bg-gray-300 rounded w-96"></div>
					<div class="h-2 bg-gray-300 rounded w-96"></div>
				</div>
			</div>
			<input id="page" value="<?php se($current_page); ?>" class="hidden" />

			<?php if ($total_pages > 0) : ?>
				<?php include __DIR__ . '/../utils/pagination.php' ?>
			<?php elseif ($total_pages == 0) : ?>
				<div class="p-4 bg-gray-100 rounded my-4">
					<div class="space-y-2 ">
						<h4 class="text-gray-700">No reviews for this product</h4>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<script>
	const ratings = document.querySelectorAll('.rating');
	let rate = 0;
	let clicked = false;
	ratings.forEach(rating => {
		rating.addEventListener('click', (e) => {
			const index = rating.dataset.index;
			rate = rating.dataset.index;
			if (e.currentTarget.contains(rating)) {
				for (let i = 0; i < index; i++) {
					ratings[i].classList.add('fill-current')
				}
			}
		})
	})

	const reset = () => {
		ratings.forEach(rating => {
			rating.classList.remove('fill-current');
		})
		document.getElementById('comment').value = "";
		document.getElementById('product_id').value = "";
	}
	const showReviews = () => {
		const product_id = document.getElementById('product_id').value;
		const page = document.getElementById('page').value;
		const type = document.getElementById('type').value;
		const direction = document.getElementById('direction').value;

		$.ajax({
			type: 'GET',
			url: './../api/get_comments.php',
			data: {
				product_id: product_id,
				page: page,
				type: type,
				direction: direction
			},
			beforeSend: () => {
				const reviewLoader = document.getElementById('review-loading')
				reviewLoader.classList.remove('hidden');
			},
			success: (data) => {
				const reviewLoader = document.getElementById('review-loading')
				reviewLoader.classList.add('hidden');

				$('#reviews').html(data);
			}
		})
	}
	const submitReview = (e) => {
		e.preventDefault();
		const comment = document.getElementById('comment').value;
		const product_id = document.getElementById('product_id').value;
		let errors = 0;
		if (comment.length === 0) {
			window.scrollTo(0, 0);
			flash('Comment must not be empty', "bg-yellow-200", 1200, "fade");
			errors++;
		}
		if (rate === 0) {
			window.scrollTo(0, 0);
			flash('Must choose a rating', "bg-yellow-200", 1200, "fade");
			errors++
		}
		if (errors === 0) {
			$.ajax('./../api/rate_product.php', {
				type: 'POST',
				data: {
					comment: comment,
					rate: rate,
					product_id: product_id
				},
				beforeSend: () => {
					const loading = document.getElementById("loading");
					loading.classList.remove("hidden");
				},
			}).done((jsonres, x, y) => {
				const loading = document.getElementById("loading");
				loading.classList.add("hidden");
				let res = JSON.parse(jsonres);
				if (res.status === 200) {
					flash(res.message, "bg-green-200", 1000, 'fade');
					location.reload();
				} else if (res.status === 500) {
					flash(res.message, "bg-yellow-200", 1000, 'fade');
				} else {
					flash(res.message, "bg-red-200", 1000, 'fade');
				}
				window.scrollTo(0, 0);
				document.getElementById('comment').value = ""
				reset();
			})
		}
	}
	const clearFilter = () => {
		document.getElementById('type').value = 'ratings';
		document.getElementById('direction').value = 'desc';
		showReviews();
	}


	$(document).ready(
		showReviews()
	)
	$(document).ready(
		product_page_get_cart_count()
	)

	function product_page_add_to_cart(e) {
		const product_id = e.id
		const qty = document.getElementById("quantity").value;;
		$.post("./../cart/add_to_cart.php", {
			product_id: product_id,
			quantity: qty,
		}, (res) => {
			const data = JSON.parse(res);
			const {
				message,
				status
			} = data
			if (status === 200) {
				product_page_get_cart_count();
				window.scrollTo(0, 0);
				flash(message, "bg-green-200", 1000, "fade");
			}
		})
	}

	function product_page_get_cart_count() {
		$.get("./../products/get_cart_count.php", (res) => {
			let data = JSON.parse(res);
			const {
				message,
				status,
				logged_in
			} = data
			if (logged_in) {
				if (status === 200) {
					product_page_change_cart_counter(message);
				} else {
					flash(message, "bg-red-200", 1000, "fade");
				}
			}
		})
	}

	function product_page_change_cart_counter(message) {
		const cart = document.getElementById("cart-count");
		cart.innerText = message.count
	}
</script>
<?php
require(__DIR__ . "../../../../partials/flash.php");
?>
<script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>