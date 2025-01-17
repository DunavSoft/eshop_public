<div class="d-none" id="pageType">2</div>
<section class="page-content">
	<div class="container ">

		<h1 class="page-title"><?= $property->title ?></h1>
		<span class="blue-strip-page "></span>
		<br>
		<p>
			<div class="property-details off-details">
				<div class="row">
					<div class="col-xxl-6 col-xl-5">
					<?php $imagesDescr = json_decode($property->images_description);?>
					
					<?php $i = 0; foreach ($images as $image) : ?>
						<div class="image-group <?php if ($i > 0) : ?>mt-4<?php endif; ?>">
							<?php if ($i == 0) : ?>
								<!-- <div class="promo"><?= $property->discount ?></div> -->
							<?php endif; ?>
							<img class="img-fluid img-property" src="<?= base_url($image->image) ?>" alt="<?= $imagesDescr[$i]->img_alt ?? '' ?>" title="<?= $imagesDescr[$i]->img_title ??'' ?>" />
						</div>
					<?php $i++; endforeach; ?>
					
					<?php if (count($images) == 0) : ?>
						<div class="image-group">
							<!-- <div class="promo"><?= $property->discount ?></div> -->
							<img class="img-fluid img-property" src="/assets/images/no_image.png" alt="" title="" />
						</div>
					<?php endif; ?>
					
					</div>
 
					<div class="col-xxl-6 col-xl-7">
						<div class="wrap-property-details-info">
						<p class="property-title-property"><?= $property->title ?></p>
							<?= $property->content ?>
						</div>
					</div>

					<hr style="margin: 60px 0 30px;border-bottom: 1px solid #3e3e3e;" />
					<div class="property-details-clock">
					<p class="property-clock-txt"><?= lang('PropertiesLang.expires_after') ?>:</p>
					<!--Тук трябва да влеза крайната дата в този формат 2023-03-30 12:00:00 !!!-->

					<p class="d-none time-end"><?= date('Y-m-d H:i:s', $property->date_end) ?></p>

					<ul class="list-unstyled list-inline list-date">
						<li class="list-inline-item">
						<p class="property-num day">&nbsp;</p>

						<p class="property-num-txt"><?= lang('PropertiesLang.days') ?></p>
						</li>
						<li class="list-inline-item">
						<p class="property-num hour">&nbsp;</p>

						<p class="property-num-txt"><?= lang('PropertiesLang.hours') ?></p>
						</li>
						<li class="list-inline-item">
						<p class="property-num minutes">&nbsp;</p>

						<p class="property-num-txt"><?= lang('PropertiesLang.minutes') ?></p>
						</li>
						<li class="list-inline-item">
						<p class="property-num seconds">&nbsp;</p>

						<p class="property-num-txt"><?= lang('PropertiesLang.seconds') ?></p>
						</li>
					</ul>
					</div>
				</div>
				<a class="get-property" href="tel:0700 14 680"><img alt="arrow" class="img-phone" src="/assets/images/icons/phone.svg" /> <?= lang('PropertiesLang.reserve') ?> </a>
			</div>
		</p>
	</div>
</section>