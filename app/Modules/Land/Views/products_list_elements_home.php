<?php foreach ($products as $product) : ?>
    <?php $catSlug = isset($product->categorySlug) ? $product->categorySlug : '';

    if ($product->promo_price > 0 && $product->price != 0) {
        $percent_calculate = (($product->promo_price - $product->price) / $product->price) * 100;
        $percent = number_format(round($percent_calculate, 0));
    }
    ?>

    <div class="position-relative">
        <div class="wrap-home-product ">
            <a href="<?= site_url($locale . '/' . $product->routeSlug) ?>" class="prod-img-a">
                <?php if (isset($product->image->image)) : ?>
                    <img width="200" src="<?= base_url($product->image->image ?? '') ?>"
                                     class="img-fluid img-product"
                                     alt="<?= is_array($product->images_description) && isset($product->images_description['img_alt']) ? $product->images_description['img_alt'] : '' ?>"
                                     title="<?= is_array($product->images_description) && isset($product->images_description['img_title']) ? $product->images_description['img_title'] : '' ?>">
                <?php endif; ?>
                <?php if ($product->promo_price > 0 && $product->price != 0) : ?>
                    <p class="label-percent">-<?= round(100 - 100 * $product->promo_price / $product->price) ?>%</p>
                <?php endif ?>
                <?php if ($product->new_product == 1) : ?>
                    <p class="label-new <?php if ($product->promo_price > 0) : ?>level-2<?php endif ?>">
                        <?= lang('ProductsLang.new_product') ?></p>
                <?php endif ?>
            </a>

            <p class="prod-title">
                <a href="<?= site_url($locale . '/' . $product->routeSlug) ?>">
                    <?= $product->title ?>
                </a>
            </p>

            <p class="prod-brand"><?= $filterBrandsArray[$product->brand_id] ?? '' ?></p>

            <ul class="list-unstyled list-inline price-group">
                <?php if ($product->promo_price != 0) : ?>
                    <li class="list-inline-item">
                        <p class="old-price"><?= $product->price ?> <?= lang('ProductsLang.currency') ?></p>
                    </li>
                <?php endif; ?>
                <li class="list-inline-item">
                    <p class="prod-price discount">
                        <?= $product->promo_price != 0 ? $product->promo_price : $product->price ?><?= lang('ProductsLang.currency') ?>
                    </p>
                </li>

            </ul>
            
            <a href="<?= site_url($locale . '/' . $product->routeSlug) ?>">
                <div class="go-to-link">+</div>
            </a>
            <div class="num-items-group">
                    <div class="size-title"><?= lang('ProductsLang.quantity') ?>:</div>
                    <div class="form-group">
                        <?php
                        $data = [
                            'type'  => 'number',
                            'id'    => 'qty' . $product->product_id, // Unique ID for each product
                            'name'  => 'qty[]', // Using array notation for the name
                            'value' => set_value('qty', $qty ?? '1'),
                            'class' => 'form-control prod-num quantity-input', // Added 'quantity-input' class
                            'step'  => '1',
                            'min'   => '1',
                            'max'   => $product->quantity,
                        ];

                        ($product->quantity == 0) ? $data['disabled'] = true : '';
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            <div class="btn-f-group">
                    <div style="position: relative">
                    <?php if ($product->quantity == 0) : ?>
                                        <p class="m-0 text-danger" style="font-size: 24px;"><?= lang('ProductsLang.out_of_stock') ?></p>
                                    <?php endif ?>
                        <button type="submit"  class="addToCart" data-id="<?= $product->product_id ?>"
                                data-url="<?= $locale . '/' . $product->routeSlug ?? '' ?>"
                                data-image="<?= $product->image->image ?? '' ?>"
                                data-sizes="<?= $product->has_product_sizes ?>"
                                <?php if ($product->quantity == 0) : ?>disabled<?php endif ?>>
                            <i class="fa fa-plus"></i> <?= lang('ProductsLang.addToCart') ?>
                        </button>
                    </div>
            </div>
        </div>

    </div>
<?php endforeach ?>

