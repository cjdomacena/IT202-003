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
}
// id, user_id, name, description, stock, cost, image
?>

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

		</div>
	</div>
	<hr class="mt-24" />
	<div class="flex mt-4 space-x-4">
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
						<button class="py-2 px-4 hover:bg-indigo-300 rounded bg-indigo-400" onclick="submitReview()">Submit</button>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div id="reviews" class="flex-auto">

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
	}

	const submitReview = () => {
		const comment = document.getElementById('comment').value;
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
					
				}
			})
		}

	}

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