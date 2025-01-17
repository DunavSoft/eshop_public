<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $pages ?></h3>

                <p><?= lang('AdminLang.pagesCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $categories ?></h3>

                <p><?= lang('AdminLang.categoriesCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $products ?></h3>

                <p><?= lang('AdminLang.productsCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $articles ?></h3>

                <p><?= lang('AdminLang.articlesCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $galleries ?></h3>

                <p><?= lang('AdminLang.galleriesCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="card small-box bg-white">
            <div class="inner">
                <h3><?= $sliders ?></h3>

                <p><?= lang('AdminLang.slidersCount') ?></p>
            </div>

        </div>
    </div>
    <!-- ./col -->

</div>

<!-- Recent Orders -->
<?php if (in_array('Orders', $config->loadedModules)) : ?>
    <div class="card-header bg-primary">
        Списък на последните поръчки
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-nowrap"><?= lang('AdminPanel.number') ?></th>
                <th><?= lang('OrdersLang.dateCreate') ?></th>
                <th><?= lang('OrdersLang.name') ?></th>
                <th class="text-nowrap text-center"><?= lang('OrdersLang.total') ?></th>
                <th class="text-nowrap text-center"><?= lang('AdminPanel.status') ?></th>
                <th class="text-nowrap text-center"><?= lang('OrdersLang.paid') ?></th>
                <th class="project-actions text-right text-nowrap"><?= lang('AdminPanel.action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($orders) == 0) : ?>
                <tr id="row0">
                    <td colspan="9" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
                </tr>
            <?php endif; ?>
            <?php foreach ($orders as $order) : ?>
                <tr id="row<?= $order->id ?>">
                    <td>
                        <?= $order->order_number ?><br />
                    </td>

                    <td><?= date('d.m.Y H:i', strtotime($order->ordered_on)) ?></td>
                    <td><?= $order->name ?></td>
                    <td class="text-nowrap text-center"><b><?= $order->total ?></b> лв.</td>

                    <td class="text-nowrap text-center">
                        <?= lang('OrdersLang.' . $order->status) ?>
                        <?php if ($order->fast_order == 1) : ?>
                            <p class="text-nowrap mb-0"><?= lang('OrdersLang.fastOrder') ?></p>
                        <?php endif ?>
                    </td>

                    <td class="text-nowrap text-center">
                        <?php if (isset($paid[$order->id])) : ?>

                            <span class="badge badge-success"><?= lang('OrdersLang.yes_paid') ?></span>

                        <?php else : ?>

                            <span class="badge badge-danger"><?= lang('OrdersLang.not_paid') ?></span>

                        <?php endif; ?>

                    </td>

                    <td class="project-actions text-right text-nowrap">
                        <?php $order->deleted_at = '';
                        if ($order->deleted_at == '') : ?>
                            <div class="btn-group float-right">
                                <a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/orders/form/' . $order->id) ?>" data-id="orders<?= $order->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/orders') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        <?php else : ?>
                            <a class="btn btn-primary btn-sm process-button" href="<?= site_url($locale . '/admin/orders/restore/' . $order->id) ?>" data-ajax-url="<?= site_url($locale . '/admin/orders') ?>">
                                <i class="fas fa-undo-alt"></i> <?= lang('AdminPanel.restore') ?>
                            </a>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif ?>