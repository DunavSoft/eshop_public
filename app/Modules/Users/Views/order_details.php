<section class="page-details" id="request">
    <div class="container">

        <?= lang('OrdersLang.order_number') ?>: <?= $order['order_number'] ?>
        / <?= date('d.m.Y', $order['created_at']) ?>

        <br/>
        <?= lang('AdminPanel.status') ?>: <?= lang('OrdersLang.' . $order['status']) ?>

        <br/>
        <?= lang('OrdersLang.shipping_number') ?>: <?= $order['shipping_number'] ?>

        <br/>
        <br/>
        <b><?= lang('CartLang.personal_data') ?></b>

        <br/>
        <?= lang('OrdersLang.name') ?>: <?= $order['name'] ?>

        <br/>
        <?= lang('CartLang.email') ?>: <?= $order['email'] ?>

        <br/>
        <?= lang('CartLang.phone') ?>: <?= $order['phone'] ?>

        <br/>
        <br/>
        <b><?= lang('CartLang.invoice_data') ?></b>
        <br/>
        <?= lang('CartLang.payment_method') ?>: <?= $order['payment_info'] ?>

        <?php $billing_data = json_decode($order['billing_data'], true); ?>
        <?php if ($billing_data != null) : ?>

            <br/>
            <?= lang('CartLang.name_company') ?>: <?= $billing_data['company'] ?>

            <br/>
            <?= lang('CartLang.egn_eik') ?>: <?= $billing_data['egn'] ?>

            <br/>
            <?= lang('CartLang.vat_number') ?>: <?= $billing_data['dds'] ?>

            <br/>
            <?= lang('CartLang.address') ?>: <?= $billing_data['company_address'] ?>

            <br/>
            <?= lang('CartLang.mol') ?>: <?= $billing_data['mol'] ?>

            <br/>
            <?= lang('CartLang.phone') ?>: <?= $billing_data['company_phone'] ?>

        <?php endif ?>

        <br/>
        <br/>
        <b><?= lang('CartLang.delivery') ?></b>
        <br/>
        <?= lang('CartLang.delivery_method') ?>: <?= $shippingMethods[$order['shipping_method']] ?>

        <?php $shipping_data = json_decode($order['shipping_data'], true); ?>
        <br/>
        <?= lang('CartLang.country') ?>: <?= $shipping_data['country'] ?>
        <br/>
        <?= lang('CartLang.city') ?>: <?= $shipping_data['city'] ?>
        <br/>
        <?= lang('CartLang.delivery_address') ?>: <?= $shipping_data['delivery_address'] ?>

        <br/>
        <br/>
        <b><?= lang('CartLang.comment') ?></b> : <?= $shipping_data['shipping_notes'] ?>

        <br/>
        <br/>
        <br/>

        <?php foreach ($products as $item) : ?>
            <?php $contents = (array)unserialize($item['contents']); ?>
            <div class="row mb-1" id="row-product-cart<?= $contents['cart_id'] ?>" style="margin: 50px 0">
                <div class="col-md-2">
                    <a href="<?= site_url($locale . '/' . $contents['url']) ?>" target="blank_"
                       class="prod-img-a">
                        <img src="<?= base_url($contents['image']) ?>" class="img-fluid card-img" alt="product image" style="margin: 0 auto; display: block">
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="<?= site_url($locale . '/' . $contents['url']) ?>" target="blank_">
                        <h3 class="order-prod-title"><?= $contents['name'] ?></h3>
                    </a>

                    <?php foreach ($contents['attributes_names'] as $key => $value) : ?>
                        <p><?= lang('CartLang.' . $key) ?>: <?= $value ?></p>
                    <?php endforeach ?>
                </div>

                <div class="col-md-2 text-center">
                    <p class="card-price"><?= $item['quantity'] ?> бр.</p>
                </div>
                <div class="col-md-2 text-center">
                    <?php if ($contents['promo_price'] != 0) : ?>
                        <p>
                            <del><?= $contents['price'] ?> <?= lang('CartLang.levs') ?></del>
                        </p>
                    <?php endif; ?>

                    <p class="card-price">
                        <?= number_format(($contents['promo_price'] > 0) ? $contents['promo_price'] : $contents['price'], 2, '.', ' ') ?>
                        <?= lang('CartLang.levs') ?>
                    </p>
                </div>
            </div>
        <?php endforeach ?>

        <br/>
        <div class="sum">
            <p><?= lang('CartLang.totalSum') ?>:
                <span id="subtotal">
                    <?= number_format($order['subtotal'], 2, '.', ' ') ?>
                </span> <?= lang('CartLang.levs') ?>
            </p>
        </div>
        <div class="sum">
            <p> <?= lang('CartLang.deliveryMethod') ?> : <?= $shippingMethods[$order['shipping_method']] ?></p>
        </div>
        <div class="sum">
            <p><?= lang('CartLang.delivery') ?>:
                <span id="shipping"><?= $order['shipping'] > 0 ? $order['shipping'] . lang('CartLang.levs') : lang('CartLang.free') ?></span>
            </p>
        </div>
        <div class="sum">
            <p><?= lang('CartLang.discount') ?>:
                <span id="discount">
                    <?= number_format($order['discount'] - $order['coupon_discount'], 2, '.', ' ') ?>
                </span> <?= lang('CartLang.levs') ?>
            </p>
        </div>
        <hr>

        <div class="sum">
            <p><?= lang('CartLang.coupon_code') ?>: <b><?= $order['coupon_code'] ?></b></p>
            <p><?= lang('CartLang.coupon_discount') ?>: <?= number_format($order['coupon_discount'], 2, '.', ' ') ?>
            <?= lang('CartLang.levs') ?></p>
        </div>
        <hr>

        <div class="sum sum-total text-bold">
            <p> <?= lang('CartLang.total') ?>: <span id="total"><?= number_format($order['total'], 2, '.', ' ') ?></span></p>
        </div>

    </div>
</section>