<section class="category-list" style="position: relative">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= site_url($locale . '/') ?>" class="breadcrumb-item"><?= lang('GalleriesLang.home') ?></a>
            <i class="fa fa-chevron-right"></i>
            <?= lang('GalleriesLang.pageTitle') ?>
        </div>
    </div>
</section>

<section class="gallery-header mb-2">
    <div class="container">
        <div class="container row">
            <?php foreach ($elements as $element) : ?>
                <span class="col-3 m-2">
                    <a href="<?= site_url($locale . '/' . $element->route_slug) ?>" class="">
                        <p class="prod-title"><?= $element->title ?></p>
                        <img class="img-responsive" height="200" src="<?= base_url($element->image) ?? '' ?>" />
                    </a>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</section>