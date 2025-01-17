<div class="card car-property">
	<div class="row">
		<div class="col-xxl-6 col-xl-5 align-self-center col-property-txt">
			<div class="image-group">
				<!-- <div class="promo"><?= $property->discount ?></div> -->
				<?php $imagesDescr = json_decode($property->images_description);?>
				<img class="img-fluid img-property" src="<?= $property->image ?>" alt="<?= $imagesDescr[0]->img_alt ?? 'property' ?>" title="<?= $imagesDescr[0]->img_title ?? '' ?>" />
			</div>
		</div>

		<div class="col-xxl-6 col-xl-7 align-self-end col-property-txt">
			<div class="wrap-property-txt">
			<p class="property-title-property"><?= $property->title ?></p>

			<!-- <p class="property-subtitle-property"><?= $property->excerpt ?></p> -->
			</div>

			<div class="wrap-property-clock">
				<p class="property-clock-txt"><?= lang('PropertiesLang.expires_after') ?>:</p>
				<!--Тук трябва да влеза крайната дата в този формат 2023-03-30 12:12:25 !!!-->

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
	</div>
</div>
<a class="see-all-property" href="<?= site_url($locale . '/properties-all') ?>" style="margin-top: 50px"><?= lang('PropertiesLang.see_more') ?> <img alt="arrow" class="img-arrow" src="/assets/images/icons/right-arrow.svg" /> </a>