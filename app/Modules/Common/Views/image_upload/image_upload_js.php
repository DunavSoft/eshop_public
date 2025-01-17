<!-- image upload script -->
<script>
$(document).on('click', '.submit-cropit', function(e) {
	removeImageNoConfirm(1);
});

function removeImageNoConfirm(buttonId) {
	let file = $('#image_card' + buttonId);

	var maxSize = 2 * 1024 * 1024;
	var file_size =  file.size;
	if(file_size > maxSize){
		alert('This image is too big! Must be less than 2 MB!');
		return false;
	} else {

		$('#image_card' + buttonId).remove();
	
		array_index = $images_array.indexOf(parseInt(buttonId));
		
		if (array_index != -1) {
			$images_array.splice(array_index, 1);
		}
	}

	
}
</script>