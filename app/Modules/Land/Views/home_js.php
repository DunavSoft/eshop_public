<script>
    $(document).ready(function() {
        $(document).on('submit', '.subscribe-form', function(event) {
            event.preventDefault();
            var $form = $(this);

            // Check if form is valid
            if (!$form[0].checkValidity()) {
                event.stopPropagation();
                $form.addClass('was-validated');
                return;
            }

            var $submitButton = $form.find('.submit-subscribe');
            $submitButton.prop('disabled', true);
            var formData = $form.serialize();

            $submitButton.text("<?= lang('AdminPanel.please_wait') ?>");

            $.ajax({
                type: 'POST',
                url: '<?= site_url($locale . '/users/emailsubscribe') ?>',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Find the closest ancestor of the form which is a subscription section
                    // and then find .subscribe-error and .subscribe-success within this section
                    var $section = $form.closest('.subscribe');
                    var $errorDiv = $section.find('.subscribe-error');
                    var $successDiv = $section.find('.subscribe-success');

                    if (response.status == 'error') {
                        let errorMessage = '';
                        for (let key in response.message) {
                            if (response.message.hasOwnProperty(key)) {
                                errorMessage += response.message[key] + '<br>';
                            }
                        }

                        $errorDiv.html(errorMessage).removeClass('d-none');
                        $successDiv.addClass('d-none');
                        $submitButton.text("{subs-3}");
                    }

                    if (response.status == 'success') {
                        $successDiv.html('{text-subscribe-success}').removeClass('d-none');
                        $errorDiv.addClass('d-none');
                        $form[0].reset();
                        $form.hide();
                    }

                    $submitButton.prop('disabled', false);
                },
                error: function(error) {
                    console.error('Error in AJAX call:', error);
                }
            });
        });

        $('.hold-img-slider').removeClass('d-none');
    });

    <?php if ((!session()->has('isLoggedIn') && !session()->isLoggedIn && !session()->has('userData')) ||
        (isset(session()->userData['subscription']) && session()->userData['subscription'] == 0)
    ) : ?>
        $(document).ready(function() {
            var modalShownTime = <?= session('modal_last_shown') ?? 0 ?>;
            var currentTime = Math.floor(Date.now() / 1000); // Current time in seconds

            // Check if 24 hours have passed
            if ((currentTime - modalShownTime) >= 86400) {
                $('#subscribeModal').modal('show'); // Show the modal
            }

            // Update session time when modal is closed
            $('#subscribeModal').on('hidden.bs.modal', function(e) {
                $.ajax({
                    url: '<?= site_url($locale . '/update_session') ?>', // Controller method to update session time
                    type: 'POST',
                    success: function(response) {
                        modalShownTime = Math.floor(Date.now() / 1000);
                    }
                });
            });
        });
    <?php endif ?>
</script>