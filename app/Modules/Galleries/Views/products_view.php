<section class="product-info" style="position: relative">
    <img src="<?= base_url('assets/images/header-short-bg.jpg') ?>" class="img-fluid img-category"
         alt="category-football">
    <div class="prod-logo-title">
        <img src="<?= base_url('assets/images/svg/subliton_logo_white.svg') ?>" class="img-fluid img-logo-cat"
             alt="logo-white">
        <h1 class="category-title"><?= $category->excerpt ?></h1>
    </div>
</section>

<section class="products">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 prod-left-col">
                <div class="slider prod-slider">
                    <?php $i = 0;
                    foreach ($images as $image): ?>
                        <?php $imagesDescription = json_decode($element->images_description); ?>
                        <div class="zoom-effect">
                            <a href="<?= $image->image ?>" data-fancybox="gallery">
                                <img src="<?= $image->image ?>" class="img-fluid prod-main-img"
                                     alt="<?= $imagesDescription[$i]->img_alt ?>" 
                                     title="<?= $imagesDescription[$i]->img_title ?>">
                            </a>
                        </div>
                    <?php $i++; endforeach; ?>
					
					<?php if (count($images) == 0):?>
						<div class="zoom-effect">
                            <a href="<?=base_url('/assets/images/noimage.png')?>" data-fancybox="gallery">
                                <img src="<?=base_url('/assets/images/noimage.png')?>" class="img-fluid prod-main-img">
                            </a>
                        </div>
					<?php endif;?>
                </div>
                <div class="slider-nav">
                    <?php 
					if (count($images) > 1):
					$i = 0;
                    foreach ($images as $image): ?>
                        <div class="zoom-effect">
                            <img src="<?= $image->image ?>" class="img-fluid prod-thumb-img"
                                 alt="<?= $imagesDescription[$i]->img_alt ?>"
								 title="<?= $imagesDescription[$i]->img_title ?>">
                        </div>
                    <?php $i++; endforeach; 
					endif; ?>
                </div>

            </div>
            <div class="col-lg-6 prod-right-col">
                <h1 id="product-title"><?= $element->title; ?></h1>

                <p class="product-description">
                    <?= $element->content; ?>
                </p>
                <div class="go-to-request" style="margin-top: 60px">
                    <a role="button" class="btn-send-req"
                       data-bs-toggle="modal"
                       data-bs-target="#prod-request" id="sendRequest">
                        <?= lang('GalleriesLang.inquiry') ?> 
                    </a>
                </div>
                <div class="call-us">
                <p><?= lang('GalleriesLang.callUs') ?> </p>
                <p>
                    <a href="tel:0898759058"><?= lang('GalleriesLang.phoneNumber') ?></a>
                </p>
                </div>
                <ul class="list-inline list-unstyled cal-soc">
                    <li class="list-inline-item">
                        <a href="viber://chat?number=%2B359898759058" target="_blank">
                            <img src="<?= base_url('assets/images/viber.svg') ?>" class="prod-soc" alt="viber">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="whatsapp://send?phone=+359898759058" target="_blank">
                            <img src="<?= base_url('assets/images/whatsapp.svg') ?>" class="prod-soc" alt="viber">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="http://m.me/Subliton" target="_blank">
                            <img src="<?= base_url('assets/images/messenger.svg') ?>" class="prod-soc" alt="viber">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
try {
    echo view('App\Modules\Questions\Views\contact_form_modal');
} catch (Exception $e) {
    echo "<pre><code>$e</code></pre>";
}
?>