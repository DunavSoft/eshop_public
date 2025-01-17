<script>
// https://codepen.io/WebFikirleri/pen/PowKYJN

$(document).ready(function() {
	create_sortable();
});

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

function create_sortable()
{
	$('#images_sortable').sortable({
		scroll: true,
		helper: fixHelper,
		handle: '.handle',
		axis: 'y',
		placeholder: 'bg-primary p-5',
		update: function(){
		//save_sortable(); !!! ATTENTION: The ordering is disabled
		}
	});	
	$('#images_sortable').sortable('enable');
}

function save_sortable()
{
	<?php if ((int)$id > 0):?>
	$('#ordering_help').html('<?= lang('AdminPanel.please_wait') ?>');
	
	serial = $('#form ').serialize();
	
	$.ajax({
		url:'<?= site_url($locale . '/admin/galleries/process_ordering/' . $id) ?>',
		type:'POST',
		data:serial,
		dataType: 'json',
		error: function() {
            $('#ordering_help').html('<span class="text-danger"><?= lang('AdminPanel.something_wrong') ?><span>');
        },
		success: function(response) {
			
			if (response.success == "success") {
				
				$images_array = [];
				$images_array.push('0');
				$.each(response.nrImageArray, function( key, value ) {
					$images_array.push( value );
				});
				
				$.each(response.newIdArray, function( key, value ) {
					//to delete content of the image and assign the new id
					$('#image' + key).remove();
					$('#galleries_img' + key).prop('name', 'galleries_images['+ key +'][id]');
					$('#galleries_img' + key).val(value);
				});
			   
				$('#ordering_help').html('<?= lang('GalleriesLang.ordering_help') . lang('GalleriesLang.ordering_saved') ?>');
			} else {
				$('#ordering_help').html('<span class="text-danger"><?= lang('AdminPanel.something_wrong') ?><span>');
			}
        }
	});
	<?php endif;?>
}
</script>