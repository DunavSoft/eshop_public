<?php if (count($elements) > 0) :?>
<section class="sec-3">
    <div class="blue-strip"></div>
    <div class="container">
        <?php foreach ($elements as $property) {
			$passArray['property'] = $property;
			echo view('\App\Modules\Properties\Views\offers_element_homepage', $passArray);
		} ?>
    </div>
</section>
<?php endif; ?>