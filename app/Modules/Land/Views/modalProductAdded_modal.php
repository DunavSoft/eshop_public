<div class="modal fade" id="ModalProductAdded" tabindex="-1" aria-labelledby="ModalSizesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalSizesLabel"><?= lang('AdminPanel.productAdded') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modal_image" height="350" />

                <p class="m-0 mt-2 fs-5 fw-semibold">
                    <span id="modal_title"></span>

                    <span id="modal_size"></span>

                    <!--<span class="product-sku" id="modal_sku"></span>-->
                </p>
                <p class="fs-5 fw-semibold m-0 pt-0"><span id="modal_qty"></span> x <span id="modal_promo_price" class="prod-price discount"></span>
                    <span id="modal_price" class=""></span>
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary border-0 custom-button-modal" type="button" data-bs-dismiss="modal">
                    <?= lang('AdminPanel.continue') ?>
                </button>

                <a href="<?= site_url($locale . '/cart/checkout') ?>" class="btn btn-secondary border-0 bg-danger rounded-0 ms-auto custom-button-modal" type="button"><?= lang('AdminPanel.orderNow') ?></a>
            </div>
        </div>
    </div>
</div>