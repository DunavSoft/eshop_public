<div class="d-none" id="pageType">2</div>
<section class="page-content">
	<div class="container ">

		<h1 class="page-title"><?= lang('PropertiesLang.moduleTitle') ?></h1>
		<span class="blue-strip-page "></span>
		<br>
		<p>
		<?php foreach ($elements as $property) {
			$passArray['property'] = $property;
			echo view('\App\Modules\Properties\Views\offers_element', $passArray);
		} ?>
		</p>
	</div>
</section>