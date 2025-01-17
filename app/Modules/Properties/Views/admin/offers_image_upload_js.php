<script>
function readFile(input, id) {
	if (input.files && input.files[0]) {
		var FR = new FileReader();
    
		FR.addEventListener("load", function(e) {
			console.log(e.target.result);
			document.getElementById("current_" + id).src = e.target.result;
			document.getElementById(id).value = e.target.result;
			document.getElementById("removeButton_" + id).style.display = 'inline-block';
		});
    
		FR.readAsDataURL(input.files[0]);
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