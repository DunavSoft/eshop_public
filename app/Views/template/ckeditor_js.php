<script>
var editor_config = {
	filebrowserBrowseUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/ckfinder.html');?>',
	filebrowserImageBrowseUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/ckfinder.html?type=Images');?>',
	filebrowserUploadUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files');?>',
	filebrowserImageUploadUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images');?>',
	cloudServices_tokenUrl: '<?php echo base_url(); ?>',
	cloudServices_uploadUrl: '<?php echo site_url('uploads/wysiwyg'); ?>',
  allowedContent: true,
  extraPlugins: 'youtube',
  contentsCss: '<?php echo base_url('admin_panel/plugins/fontawesome-free/css/all.min.css'); ?>',
  removeButtons: 'Flash,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Iframe,Language,NewPage,Templates,SelectAll,SpellChecker,Paste,PasteText'
};

$('.ckeditor').each(function( index, formtextarea ) {
	if (formtextarea.id == '') {
		$(formtextarea).attr('id', 'myckeditorcustomid' + index);
	}

	// allow i tags to be empty (for font awesome)
	CKEDITOR.dtd.$removeEmpty['i'] = false;

	var editor = CKEDITOR.replace(formtextarea.id, editor_config);

	CKFinder.setupCKEditor(editor, '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder'); ?>');
});

// attention: use this for ajax submitting the form **//
/*
CKEDITOR.on('instanceReady', function(){
   $.each( CKEDITOR.instances, function(instance) {
    CKEDITOR.instances[instance].on('change', function(e) {
        for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
    });
   });
});
*/

$(function () {
	$('[data-tooltip="tooltip"]').tooltip()
})
</script>