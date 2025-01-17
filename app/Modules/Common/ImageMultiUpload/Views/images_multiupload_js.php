<!-- images multiupload script -->
<script>
//TODO - да се зарежда във формата (с друг масив). Също и за сорт.js!!!
var $images_array = [];
$images_array.push(0);

<?php $i = 0; foreach ($imagesArray as $image): $i++;?>
	$images_array.push(<?= $i ?>);
<?php endforeach; ?>

function readFile(input, id) {
	if (input.files && input.files[0]) {
		var FR = new FileReader();
    
		var maxSize = 2 * 1024 * 1024;
		var file_size =  input.files[0].size;
		if(file_size > maxSize){
			alert('This image is too big! Must be less than 2 MB!');
			return false;
		} else {

			FR.addEventListener("load", function(e) {
				$('#current_image0').attr('src', e.target.result);
				$('#image0').val(e.target.result);
				
				//document.getElementById("remove_button" + id).style.display = 'inline-block';
			});
		
			FR.readAsDataURL(input.files[0]);

			return true;
		}
	
	
	}
}

<?php if ($config->useCropImages != true):?>
$('.cropit-image-input').on('change', function(e) {

	let imageId = this.id.replace("upload_", "");
	
	let result = readFile(this, imageId);
	
	window.setTimeout(function() {
        if(result == true){
			cloneImage();
		}
    }, 500);
	
	$('.cropit-image-input').val('');
});
<?php endif;?>

function removeImage(id) {
	if (confirm('<?= lang('CommonLang.image_delete_sure') ?>')) {
		let buttonId = id.replace('remove_button', '');
		
		$('#image_card' + buttonId).remove();
		
		array_index = $images_array.indexOf(parseInt(buttonId));
		
		if (array_index != -1) {
			$images_array.splice(array_index, 1);
		}

		$('#ordering_help').html('<?= lang('CommonLang.ordering_help') . lang('CommonLang.please_save') ?>');
	}
}

//$(document).on('click', '#remove-all-images-button', function(e) {
$('#remove-all-images-button').click(function() {
	if (confirm('<?= lang('CommonLang.image_delete_sure_all') ?>')) {
		
		console.log($images_array);
		
		var imagesArraySize = $images_array.length;
		
		for (i = 1; i <= imagesArraySize; i++) {
			
			array_index = $images_array.indexOf(parseInt(i));
			
			if (array_index != -1) {
				$images_array.splice(array_index, 1);
			}
		
			$('#image_card' + i).remove();
		}
		
		$('#ordering_help').html('<?= lang('CommonLang.ordering_help') . lang('CommonLang.please_save') ?>');
	}
});

function cloneImage()
{
  // get the last DIV which ID starts with ^= "image_card"
	var $div = $('#image_card0');
	
	old_image_id = $images_array[$images_array.length - 1];
	new_image_id = old_image_id + 1;
	
	var $clone = $('#image_card0').clone();
  
	$clone.prop('id', 'image_card' + new_image_id);
	
	//updated
	if ($images_array.length == 1) {
		$($clone).insertAfter('#image_card_sortable');
	} else {
		$($clone).insertAfter('#image_card' + old_image_id);
	}
	
	$('#image_card' + new_image_id).find('#image_container0').prop('id', 'image_container' + new_image_id);
	
	$('#image_card' + new_image_id).find($('.image_container')).removeClass('d-none');
	
	$('#image_card' + new_image_id).find($('label[for="upload_image0"]')).addClass('d-none');
	$('#image_container' + new_image_id).addClass('d-none');
	  
	$('#image_card' + new_image_id).find('#image0').prop('id', 'image' + new_image_id);
	$('#image_card' + new_image_id).find('#upload_image0').prop('id', 'upload_image' + new_image_id);
	$('#image_card' + new_image_id).find('#current_image0').prop('id', 'current_image' + new_image_id);
	$('#image_card' + new_image_id).find('#image0').prop('id', 'image' + new_image_id);
	$('#image_card' + new_image_id).find('#sorting_image0').val(new_image_id);
	$('#image_card' + new_image_id).find('#sorting_image0').prop('id', 'sorting_image' + new_image_id);
	
	// $images_table_name - name of th images post array
	$('#image' + new_image_id).prop('name', '<?= $images_table_name ?>['+ new_image_id +'][image]');

	$('#image_card' + new_image_id).find('#remove_button0').prop('id', 'remove_button' + new_image_id);
	$('#image_card' + new_image_id).find('#galleries_img0').prop('id', 'galleries_img' + new_image_id);
	$('#image_card' + new_image_id).find('#sorting_image0').prop('id', 'sorting_image' + new_image_id);
	$('#image_card' + new_image_id).removeClass('bg-light');

	$images_array.push(new_image_id);
	
	$('.cropit-preview-image').attr('src', '');
	
<?php foreach ($languagesSite as $language): ?>
	$('#image_card' + new_image_id).find('#img_alt' + <?= $language->id ?> + '0').prop('id', 'img_alt' + <?= $language->id ?> + new_image_id);
	$('#image_card' + new_image_id).find('#img_title' + <?= $language->id ?> + '0').prop('id', 'img_title' + <?= $language->id ?> + new_image_id);
//   $clone.prop('id', 'img_alt' + <?= $language->id ?> + new_image_id);
//   $clone.prop('id', 'img_title' + <?= $language->id ?> + new_image_id);
	$('#img_alt' + <?= $language->id ?> + '0').val('');
   
	$('#img_alt' + <?= $language->id ?> + new_image_id).prop('name', 'images_desc[' + <?= $language->id ?> + ']['+ new_image_id +'][img_alt]');

	$('#img_title' + <?= $language->id ?> + '0').val('');
	$('#img_title' + <?= $language->id ?> + new_image_id).prop('name', 'images_desc[' + <?= $language->id ?> + ']['+ new_image_id +'][img_title]');
<?php endforeach;?>
}
</script>
<?php if ($config->useCropImages):?>
<!-- cropit -->
<link rel="stylesheet" href="<?= base_url('admin_panel/plugins/cropit/css/cropit.css') ?>">

<script src="<?= base_url('admin_panel/plugins/cropit/js/jquery-migrate-3.0.1.js') ?>"></script>
<script src="<?= base_url('admin_panel/plugins/cropit/js/jquery.cropit.js') ?>"></script>

<script>
$(document).on('change', '.cropit-image-input', function(e) {
	$('.submit-cropit').removeClass('disabled');
	$('#dont_forget_to_upload').removeClass('d-none');
});

/* cropit js */
$(function() {
	
	/* cropit js */ //its moved in the form because is ajax and it doesnt work here !!!
	
	$('.image-editor').cropit({
		exportZoom: <?= $config->cropExportZoom ?>,
		width: <?= $config->cropWidth ?>,
		height: <?= $config->cropHeight ?>,
		smallImage: 'allow'
	});

	//$(document).on('click', '.submit-cropit', function() {
	$('.submit-cropit').click(function() {
		
		let imageId = this.id.replace("upload_", "");
		
		// Move cropped image data to hidden input
		var imageData = $('.image-editor').cropit('export');
	  
		$('#current_image0').attr('src', imageData);
		$('#image0').val(imageData);
		
		window.setTimeout(function() {
			cloneImage();
		}, 500);
		
		$('.cropit-preview-image-container').addClass('disabled');
		$('.cropit-image-input').val('');
		$('.submit-cropit').addClass('disabled');
		$('#dont_forget_to_upload').addClass('d-none');
		//window.open(imageData);
	});
});
</script>
<?php endif;?>