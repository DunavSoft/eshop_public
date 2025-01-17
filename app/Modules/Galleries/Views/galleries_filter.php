<?php if (isset($galleryTitle)) : ?>
	<section class="category-list" style="position: relative">
		<div class="container">
			<div class="breadcrumb">
				<a href="<?= site_url($locale . '/') ?>" class="breadcrumb-item"><?= lang('GalleriesLang.home') ?></a>
				<i class="fa fa-chevron-right"></i>
				<a href="<?= site_url($locale . '/galleries-all') ?>" class="breadcrumb-item"><?= lang('GalleriesLang.pageTitle') ?></a>
				<i class="fa fa-chevron-right"></i>
				<?= $galleryTitle ?? '' ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php $i = 0; ?>
<?= $images[0]->gallery_tag_open ?? '' ?>

<?php
foreach ($images as $image) : ?>
	<?php $imagesDescription = json_decode($image->images_description); ?>
	<?= $image->gallery_element_tag_open ?? '' ?>
	<a class="<?= $image->gallery_a_class ?>" href="<?= $image->image ?? '' ?>" data-fancybox="gallery">
		<img src="<?= $image->image ?? '' ?>" class="<?= $image->gallery_image_class ?? '' ?>" alt="<?= $imagesDescription[$i]->img_alt ?? '' ?>" title="<?= $imagesDescription[$i]->img_title ?? '' ?>">
	</a>
	<?= $image->gallery_element_tag_close ?? '' ?>
<?php $i++;
endforeach; ?>

<?= $images[0]->gallery_tag_close ?? '' ?>