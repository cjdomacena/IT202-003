<?php
if (!isset($current_page)) {
	$current_page = 1;
}
if (!isset($total_pages)) {
	$total_pages = 1;
}

?>

<ul class="inline-flex items-center -space-x-px mt-4">
	<li>
		<?php if (($current_page - 1) <= 0) : ?>
			<a href="?<?php pagination_filter(1) ?>" class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
				<span class="sr-only">Previous</span>
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
				</svg>
			</a>
		<?php else : ?>
			<a href="?<?php pagination_filter($current_page - 1) ?>" class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
				<span class="sr-only">Previous</span>
				<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
				</svg>
			</a>
		<?php endif ?>
	</li>
	<?php for ($i = 0; $i < $total_pages - 1; $i++) : ?>
		<?php if ($i + 1 == $current_page) : ?>
			<li>
				<a href="?<?php pagination_filter($i + 1) ?>" class="px-3 py-2 bg-indigo-600 rounded leading-tight text-gray-50 bg-white border border-gray-300 hover:bg-indigo-500"><?php echo $i + 1 ?></a>
			</li>
		<?php else : ?>
			<li>
				<a href="?<?php pagination_filter($i + 1) ?>" class="px-3 py-2 rounded leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><?php echo $i + 1 ?></a>
			</li>
		<?php endif; ?>
	<?php endfor; ?>
	<li>
		<a href="#" class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
			<span class="sr-only">Next</span>
			<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
			</svg>
		</a>
	</li>
</ul>