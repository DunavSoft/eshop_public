<!-- Bootstrap Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Optional Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="subscribeModalLabel"></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body with Form -->
            <div class="modal-body subscribe">
                <form class="needs-validation subscribe-form" novalidate method="post">
                    <p>{subs-1}</p>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="<?= lang('LandLang.yourEmail') ?> *" required>
                    </div>

                    <div class="form-group">
                    <?php $randomNumber = rand(1000, 9999); ?>
                        <input class="form-check-input" type="checkbox" value="1" id="warn<?= $randomNumber ?>" name="warn" required style="border:1px solid">
                        <label class="form-check-label" for="warn<?= $randomNumber ?>">
                            {subs-2}
                        </label>
                    </div>

                    <button class="submit-subscribe btn btn-secondary border-0 bg-danger rounded-0 ms-auto custom-button-modal" type="submit">
                        {subs-3}
                    </button>
                </form>

                <div class="subscribe-error alert alert-danger text-center d-none mt-2"></div>
                <div class="subscribe-success alert alert-success text-center d-none"></div>
            </div>

            <!-- Optional Modal Footer  -->
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<?php
/*
<!-- Modal Trigger Button (you can place this anywhere in your HTML) -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subscribeModal">
    Open Subscription Form
</button>
*/
?>