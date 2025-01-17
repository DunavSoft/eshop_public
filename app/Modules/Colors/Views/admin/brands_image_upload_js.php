<script>
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
				console.log(e.target.result);
				document.getElementById("current_" + id).src = e.target.result;
				document.getElementById(id).value = e.target.result;
				document.getElementById("removeButton_" + id).style.display = 'inline-block';
			});
		
			FR.readAsDataURL(input.files[0]);
		}

		
	}
}

$('.uploadable').on('change', function (e) {
	let imageId = this.id.replace("upload_", "");
    readFile(this, imageId);
});

function removeImage(id) {
	if (confirm('Are you sure to remove the image?')) {
		document.getElementById("current_" + id).src = '';
		document.getElementById(id).value = '';
		document.getElementById("removeButton_" + id).style.display = 'none';
	}
}
</script>