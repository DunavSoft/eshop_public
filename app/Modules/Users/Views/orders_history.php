<section class="request page-details" id="request-1">
    <div class="container">

        <div class="mb-5">
            <h3 class="mt-2"><i class="fa fa-chevron-right"></i> <?= lang('AdminPanel.bonito_club') ?> </h3>
            <div class="oborot">
                <p class="mb-1 ob-txt"><?= lang('CartLang.turnover') ?>: <span class="ob-price"><b><?= $turnover ?></b>  <?= lang('CartLang.levs') ?> </span></p>
                <p class="mb-1 ob-txt"><?= lang('CartLang.loyalClientDiscount') ?>: <span class="ob-price"><b><?= $percent_loyalclient ?></b> %</span>
                </p>
            </div>

        </div>

        <div class="d-flex align-items-center mb-5">
            <h3 class="m-0"><i class="fa fa-chevron-right"></i><?= lang('CartLang.myOrders') ?></h3>
        </div>

        <?php if (count($myOrders) == 0) : ?>
            <div class="row border-bottom">
                <span class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></span>
            </div>
        <?php else : ?>
            <div class="d-xl-none d-xxl-none d-md-none d-lg-none fw-bold text-center">
                <span class="col text-center "><?= lang('CartLang.ordersData') ?></span>
                <hr>
            </div>
            <div class="d-sm-block d-none f-header">
                <div class="row border-bottom fw-bold ">
                    <span class="col text-center "><?= lang('AdminPanel.number') ?><br/><?= lang('OrdersLang.dateCreate') ?></span>
                    <span class="col text-center"><?= lang('OrdersLang.shipping_number') ?></span>
                    <span class="col text-center"><?= lang('OrdersLang.name') ?><br/><?= lang('CartLang.phone') ?></span>
                    <span class="col text-center"><?= lang('CartLang.email') ?></span>
                    <span class="col text-center"><?= lang('OrdersLang.total') ?></span>
                    <span class="col text-center"><?= lang('AdminPanel.status') ?></span>
                    <span class="col text-center"></span>
                </div>
            </div>
        <?php endif ?>

        <?php foreach ($myOrders as $element) : ?>
            <div class="row border-bottom row-my-order">
        <span class="col text-center order-num"><b><?= $element->order_number ?></b><br/>
          <p class="text-nowrap"><small><?= date('d.m.Y H:i', strtotime($element->ordered_on)) ?></small></p>
        </span>
                <span class="col text-center"><?= $element->shipping_number ?></span>
                <span class="col text-center"><?= $element->name ?><br/><?= $element->phone ?></span>
                <span class="col text-center"><?= $element->email ?></span>
                <span class="col text-center"><b><?= $element->total ?></b>  <?= lang('CartLang.levs') ?> </span>
                <span class="col text-center"><?= lang('OrdersLang.' . $element->status) ?></span>

                <span class="col text-center">
          <a class="" href="<?= site_url($locale . '/users/order/' . $element->id) ?>"
             title="<?= lang('AdminPanel.view') ?>">
            <i class="fa fa-eye fa-2x"></i>
          </a>
        </span>
            </div>
        <?php endforeach ?>

    </div>
</section>