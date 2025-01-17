<script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1"></script>

<script>
    var selectedSize = '';
	var selectedSizeName = '';
    //Add To Cart
    (function() {
        $(".addToCart").on("click", function(e) {

            $('#text-success').addClass('d-none');
            $('#text-error').addClass('d-none');

            e.preventDefault();

            let productID = $(this).data("id"); // Get the product id
            let qtySelector = '#qty' + productID; // Construct the selector for the corresponding quantity input
            let qty = $(qtySelector).val(); // Get the quantity value
            let productUrl = $(this).data('url'); // Get the product url
            let productImage = $(this).data('image'); // Get the product image
            let has_sizes = $(this).data('sizes');
            
            if(has_sizes == 0 ) {
                $.ajax({
                    url: '<?= site_url($locale . '/cart/add_to_cart') ?>',
                    method: 'POST',
                    data: {
                        id: productID,
                        quantity: qty,
                        url: productUrl,
                        image: productImage,
                        attributes: {
                            'size': selectedSize
                        },
                        attributes_names: {
                            'size': selectedSizeName
                        }
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.message) {
                            $('#text-success').html(response.message);
                            $('#text-success').removeClass('d-none');

                            $('#modal_qty').html(qty);
                            $('#modal_title').html(response.title);
                            $('#modal_price').html(response.price + ' лв.');
                            $('#modal_sku').html(response.sku);
                            $('#modal_image').attr('src', '<?= base_url() ?>/' + productImage);

                            if (has_sizes) {
                                $('#modal_size').html('[<?= lang('AdminPanel.size') ?>' + ' - ' + selectedSizeName + ']');
                            } else {
                                $('#modal_size').html('');
                            }

                            $('#modal_promo_price').html('');
                            $('#modal_price').removeClass('old-price');
                            if (response.promo_price > 0) {
                                $('#modal_promo_price').html(response.promo_price + ' лв.');
                                $('#modal_price').addClass('old-price');
                            }

                            $('#ModalProductAdded').modal('show');

                            $('#cart_total_items').html(response.total_items);
                        }
                        if (response.error) {
                            $('#text-error').html(response.error);
                            $('#text-error').removeClass('d-none');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
            else{
                let fullUrl = 'http://eshop.localhost/' + productUrl;

                // Redirect to the full URL
                window.location.href = fullUrl;
            }
        });
    })();

    /*$('.quantity-input').on('focusout', function() {
        var $this = $(this);
        var inputValue = parseInt($this.val());
        var maxVal = parseInt($this.attr('max'));

        if (inputValue > maxVal) {
            $this.val(maxVal);
        }
        if (maxVal == 0) {
            $this.val(1);
        }
    });*/
</script>