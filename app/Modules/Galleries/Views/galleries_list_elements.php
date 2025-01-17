<?php if (count($galleries) != 0): ?>
    <div class="blog-page row">
        <?php $i = 1;
        foreach ($galleries as $gallery) : ?>
            <?php $imagesDescr = json_decode($gallery->images_description); ?>
            <div class="col-lg-3">
                <div class="wrap-news-list">
                    <div class="row">
                        <div class="col-lg-5">
                            <a href="<?= site_url($locale . '/' . $gallery->route_slug) ?>">
                                <?php if ($gallery->image) : ?>
                                    <img class="img-fluid img-blog-small" src="<?= $gallery->image ?? ''?>"
                                        alt="<?= $imagesDescr[0]->img_alt != "" ? $imagesDescr[0]->img_alt : $gallery->title ?>"
                                        title="<?= $imagesDescr[0]->img_title != "" ? $imagesDescr[0]->img_title : $gallery->title ?>" />
                                <?php else : ?>
                                    <img class="img-fluid img-blog-small"
                                        src="https://dummyimage.com/450x400/dee2e6/6c757d.jpg"
                                        alt="<?= $gallery->title ?? '' ?>" />
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col-lg-7 align-self-center">
                            <div class="wrap-news">
                                <h4 class="newslink">
                                    <a href="<?= site_url($locale . '/' . $gallery->route_slug) ?>">
                                        <?= $gallery->title ?? '' ?>
                                    </a>
                                </h4>
                            </div>
                            <div class="wrap-news">
                                <p class="news-description">
                                    <?= character_limiter(strip_tags($gallery->meta), 80) ?>
                                </p>
                                <a class="read-more"
                                    href="<?= site_url($locale . '/' . $gallery->route_slug) ?>"
                                    style="color: #404040"><?= lang('GalleriesLang.see') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <?php endforeach; ?>
    <?php else: ?>
        <h3 class="text-center " style="color: #8f0b31;">{text_coming_soon}</h3>
    <?php endif; ?>