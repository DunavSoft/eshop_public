<script>
    var lastEditedId = 0;

    var urlListString = '<?= site_url($locale . '/admin/dashboard') ?>';

    //click on edit button
    $(document).on('click', '.edit-button', function() {

        event.preventDefault();

        var ajaxUrl = $(this).attr('href');
        var id = $(this).attr('data-id');

        //change url parameter
        var url = new URL(ajaxUrl);
        //url.searchParams.set('key', 'abs');
        window.history.pushState(null, '', url.toString());

        if (lastEditedId == id && lastEditedId != 'new') {
            //console.log('orders_js - return from edit-button');
            //return;
        }

        //get form data
        retrieveAjaxFormData(ajaxUrl, id);

    });

    //close modal event
    $(document).ready(function() {
        $("#ModalFormSecondary").on('hide.bs.modal', function() {
            var url = new URL(urlListString);
            window.history.pushState(null, '', url.toString());

            $("title").text('<?= $pageTitle ?>');

            $('#modal-secondary-success').hide();
        });
    });



    ////// form submit //////
    $(document).on('click', '.submit-button', function() {

        submitForm();
    });

    function submitForm(showMessages = true) {

        if (showMessages) {
            $('#modal-secondary-success').removeClass('d-none');
            $('#modal-secondary-success').removeClass('alert-success');
            $('#modal-secondary-success').show();
            $('#modal-secondary-success-message').html('<?= lang('AdminPanel.please_wait') ?>');
            $('.modal-body').animate({
                scrollTop: 0
            }, 'slow');
        }


        // attention: use this to save ckeditor content **//
        $.each(CKEDITOR.instances, function(instance) {
            var editor_data = CKEDITOR.instances[instance].getData();
            $('#' + instance).html(editor_data);
        });

        if (validateInputs() == false) {
            console.log('validateInputs = false!!!');
            ////////////return false;
        }

        form_data = $('#form').serialize();
        var ajaxUrl = $('#form').attr('action');
        //$('#modal-secondary-success').hide();

        $.post(ajaxUrl, form_data, function(response) {
            if (typeof response != "object") {
                alert('communication error');
                return;
            }

            if (response.status == 'success') {

                if (showMessages) {
                    $('#modal-secondary-success').addClass('alert-success');
                    $('#modal-secondary-success').removeClass('d-none');
                    $('#modal-secondary-success').show();
                    $('#modal-secondary-success-message').html(response.data.message);
                    $('#modal-secondary-error').hide();
                }

            } else if (response.status == 'error') {
                var error_message = '';
                $.each(response.data.error_message, function(key, value) {
                    error_message += '<p class="p-0 m-0">' + value + '</p>';
                });

                $('#modal-secondary-success').hide();

                $('#modal-secondary-error-message').html(error_message);
                $('#modal-secondary-error').removeClass('d-none');
                $('#modal-secondary-error').show();
            }

            retrieveAjaxListData(urlListString);

            //assign last inserted id to the form
            $('#form').attr('action', '<?= site_url($locale . '/admin/orders/form_submit') ?>/' + response.data.id);

            //change the url string
            var url = new URL('<?= site_url($locale . '/admin/orders/form') ?>/' + response.data.id);
            window.history.pushState(null, '', url.toString());

            if (showMessages) {
                $('.modal-body').animate({
                    scrollTop: 0
                }, 'slow');
            }

        }, 'json');
    }

    //validate the form
    function validateInputs() {
        var flag = true;
        $('#form input, #form select').each(
            function(index) {
                var input = $(this);

                if (validateOneField(input) == false) {
                    flag = false;
                }
            }
        );

        return flag;
    }

    //validation on focusout
    $(document).on('focusout', '.form-control', function(event) {
        //validateOneField($(this));
        validateField($(this));
    });

    function validateOneField(input) {

        if (input.attr('required') == 'required' && input.val() == '') {
            $('#' + input.attr('id')).addClass('form-control is-invalid');

            return false;
        } else {
            $('#' + input.attr('id')).removeClass('form-control is-invalid');
            $('#' + input.attr('id')).addClass('form-control is-valid');

            return true;
        }
    }

    function validateField(input) {

        var data = {
            fieldName: input.attr('name'),
            fieldValue: input.val(),
            fieldId: input.attr('id'),
        };

        $.post('<?= site_url($locale . '/admin/orders/validate_field') ?>', data, function(response) {

            if (response.status == 'success') {

                $('#' + input.attr('id')).removeClass('form-control is-invalid');
                $('#' + input.attr('id')).addClass('form-control is-valid');

                return true;
            } else if (response.status == 'error') {

                $('#feedback_' + input.attr('id')).html(response.errors);
                $('#' + input.attr('id')).addClass('form-control is-invalid');
                return false;
            }
        }, 'json');
    }

    function retrieveAjaxFormData(ajaxUrl, id) {

        $('.save-button').hide();
        $('#modal-secondary-title').html('<?= lang('AdminPanel.please_wait') ?>');
        $('#modal-form-secondary').html('<?= str_replace(array("\r\n", "\n", "\r"), '', lang('AdminPanel.modal_spinner')) ?>');

        $.get(ajaxUrl, function(response) {
            if (response.status == 'success') {
                $('#modal-secondary-error').hide();
                $('.save-button').show();

                //$('#modal-secondary-success').removeClass('d-none');
                //$('#modal-secondary-success-message').html(response.data.message);

                $('#modal-form-secondary').html(response.data.view);
                $('#modal-secondary-title').html(response.data.pageTitle);
                $("title").text(response.data.pageTitle);

                lastEditedId = id;
            } else {
                $('#modal-secondary-error-message').html(response.error_message);
                $('#modal-secondary-error').show();
                $('.save-button').hide();
                $('#modal-form-secondary').html('');
            }
        }, 'json');
    }

    function retrieveAjaxListData(ajaxUrl) {

        //$('#ajax-content').html('<?= str_replace(array("\r\n", "\n", "\r"), '', lang('AdminPanel.modal_spinner')) ?>');

        $.get(ajaxUrl, function(response) {
            $('#ajax-content').html(response);
        });
    }


    //pagination
    $(document).on('click', '.page-link', function(event) {
        event.preventDefault();

        var ajaxUrl = $(this).attr('href');
        retrieveAjaxListData(ajaxUrl);

        urlListString = ajaxUrl;

        //change url parameter
        var url = new URL(ajaxUrl);
        //url.searchParams.set('key', 'abs');
        window.history.pushState(null, '', url.toString());
    });


    $(document).on('click', '#generateShippingBtnAdd', function(event) {
        if (confirm('<?= lang('OrdersLang.are_you_sure_shipping') ?>')) {

            form_data = $('#form').serialize();

            $.ajax({
                url: '<?= site_url($locale . '/admin/shipping/speedy/CreateShipmentRequest') ?>',
                type: 'POST',
                dataType: 'json',
                data: form_data,
                success: function(response) {

                    if (response.error && response.error.message) {

                        $('#error-message-shipping').html(response.error.message + response.error.component);
                        $('#error-shipping').removeClass('d-none');
                    } else {

                        $('#generateShipping').removeClass('d-none');
                        $('#error-shipping').addClass('d-none');
                        $('#generateShippingBtnAdd').addClass('d-none');

                        $('#shipping_number').val(response.id);
                        $('#shipping_number_speedy').val(response.id);
                        $('#total').val(response.price.total);

                        submitForm(false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors
                    console.error("AJAX Error: ", textStatus, errorThrown);
                }
            });
        }
    });
    
    $(document).on('click', '#generatePdfButton', function(event) {

        form_data = $('#form').serialize();

        $.ajax({
            url: '<?= site_url($locale . '/admin/shipping/speedy/print_label') ?>',
            type: 'POST',
            data: form_data,
            xhrFields: {
                responseType: 'blob' // Ensure that XHR knows to expect a blob
            },
            success: function(response) {

                // Create a Blob from the PDF Stream
                var file = new Blob([response], {
                    type: 'application/pdf'
                });

                // Build a URL from the file
                var fileURL = URL.createObjectURL(file);

                // Create a temporary link to trigger download
                var downloadLink = document.createElement('a');
                document.body.appendChild(downloadLink);
                downloadLink.style = 'display: none';
                downloadLink.href = fileURL;
                downloadLink.download = $('#shipping_number_speedy').val() + '.pdf';

                // Programmatically trigger the download
                downloadLink.click();

                // Clean up by revoking the Object URL and removing the link element
                window.URL.revokeObjectURL(fileURL);
                downloadLink.remove();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error: ", textStatus, errorThrown);
            }
        });
    });
</script>