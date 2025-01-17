<!-- image upload script -->
<script>
$(document).on('click', '.submit-cropit', function(e) {
	removeImageNoConfirm(1);
});

<?php if ($config->useCropImages == false):?>
$('.cropit-image-input').on('change', function(e) {
	removeImageNoConfirm(1);
});
<?php endif;?>

function removeImageNoConfirm(buttonId) {
	let file = $('#image_card' + buttonId);

	var maxSize = 2 * 1024 * 1024;
	var file_size =  file.size;
	if(file_size > maxSize){
		alert('This image is too big! Must be less than 2 MB!');
	} else {

		$('#image_card' + buttonId).remove();
	
		array_index = $images_array.indexOf(parseInt(buttonId));
		
		if (array_index != -1) {
			$images_array.splice(array_index, 1);
		}
	}
	
}
</script>