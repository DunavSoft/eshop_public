<div class="row row-stuff">
	<div class="col-xxl-6 col-xl-5 align-self-center">
		<div class="image-group">
			<div class="promo"><?= $property->discount ?></div>
			<?php $imagesDescr = json_decode($property->images_description);?>
			<img alt="property" class="img-fluid img-property" src="<?= base_url($property->image) ?>" alt="<?= $imagesDescr[0]->img_alt ?? 'property' ?>" title="<?= $imagesDescr[0]->img_title ?? '' ?>" />
		</div>
	</div>

	<div class="col-xxl-6 col-xl-7 align-self-center">
	<p class="property-title"><?= $property->title ?></p>
	</div>
</div>

<div class="row justify-content-end">
	<div class="col-xxl-6 col-xl-7">
		<div class="row property-clock">
			<div class="col-xl-6">
			<p class="property-clock-txt"><?= lang('PropertiesLang.expires_after') ?>:</p>

			<p class="d-none time-end"><?= date('Y-m-d H:i:s', $property->date_end) ?></p>
			</div>

			<div class="col-xl-6">
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
<a class="see-all-property" href="<?= site_url($locale . '/properties-all') ?>"><?= lang('PropertiesLang.see_all') ?> <img alt="arrow" class="img-arrow" src="/assets/images/icons/right-arrow.svg" /> </a>