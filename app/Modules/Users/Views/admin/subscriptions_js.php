<script>
$(function() {
	let lastEditedId = 0;
	const baseUrl = '<?= site_url($locale . '/admin/users/subscriptions/' . $page) ?>';
	let urlListString = `${baseUrl}`;
	const $topSearchText = $('#top-search-text');
	
	// Utility function to retrieve data via AJAX
	function retrieveAjaxListData(ajaxUrl) {
		$.get(ajaxUrl, function(response) {
			$('#ajax-content').html(response);
		});
	}
	
	// Utility function to retrieve AJAX form data
	function retrieveAjaxFormData(ajaxUrl, id) {
		$('.save-button').hide();
		$('#modal-secondary-title').html('<?= lang('AdminPanel.please_wait') ?>');
		$('#modal-form-secondary').html('<?= str_replace(array("\r\n", "\n", "\r"), '', lang('AdminPanel.modal_spinner')) ?>');
		
		$.get(ajaxUrl, function (response) {
			if (response.status == 'success') {
				$('#modal-secondary-error').hide();
				$('.save-button').show();

				//$('#modal-secondary-success').removeClass('d-none');
				//$('#modal-secondary-success-message').html(response.data.message);
				
				$('#modal-form-secondary').html(response.data.view);
				$('#modal-secondary-title').html(response.data.pageTitle);

				window.history.replaceState({
					'pageTitle': response.data.pageTitle
				}, '', ajaxUrl);

				$("title").text(response.data.pageTitle);
				
				//lastEditedId = id;
			} else {
				$('#modal-secondary-error-message').html(response.error_message);
				$('#modal-secondary-error').show();
				$('.save-button').hide();
				$('#modal-form-secondary').html('');
			}
		}, 'json');
	}
	
	// Search functionality
	function search_ajax() {
		let form_data = $('#search_form').serialize();
		$.post('<?= site_url($locale . '/admin/users/subscriptions/search') ?>', form_data, function(response) {
			$('#ajax-content').html(response);
		});
	}
	
	// Utility function to validate a single input
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
	
	// Utility function to validate all inputs
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
	
	$(document).on('submit', '#search_form', function(event) {
		event.preventDefault();
	});
	
	$(document).on('click', '#top-search-button', function() {
		search_ajax();
	});

	// Pagination
	$(document).on('click', '.page-link', function(event) {
		event.preventDefault();
		let ajaxUrl = $(this).attr('href');
		retrieveAjaxListData(ajaxUrl);
		urlListString = ajaxUrl;
		window.history.pushState(null, '', ajaxUrl);
	});

	$topSearchText.keyup(function(e) {
		const key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		const strlen = $topSearchText.val().length;
		
		if (strlen == 0) {
			retrieveAjaxListData(urlListString);
		} else if (key == 13 || strlen > 2) {
			search_ajax();
		}
	});
	
	//click on edit button
	$(document).on('click', '.edit-button', function(event) {
		
		event.preventDefault();
		
		var ajaxUrl = $(this).attr('href');
		var id = $(this).attr('data-id');
		
		if (lastEditedId == id && lastEditedId != 'new') {
			console.log('subscriptions_js - return from edit-button');
			retrieveAjaxFormData(ajaxUrl, id);
			return;
		}
		
		lastEditedId = id;

		//get form data
		retrieveAjaxFormData(ajaxUrl, id);
	});

	//close modal event
	$(document).ready(function() {
		$("#ModalFormSecondary").on('hide.bs.modal', function () {
			var url = new URL(urlListString);
			window.history.pushState({
				'pageTitle': '<?= $pageTitle ?>'
			}, '', url.toString());
			
			$("title").text('<?= $pageTitle ?>');

			$('#modal-secondary-success').hide();
		});
	});
	
	// Add an event listener for popstate to handle the browser navigation events
	window.addEventListener('popstate', function(event) {
		// Check if the state has a pageTitle property and update the title
		if (event.state && event.state.pageTitle) {
			$("title").text(event.state.pageTitle);
		}
	});

	<?php if (!$isAjaxRequest) : ?>
	$(document).ready(function() {
		retrieveAjaxFormData('<?= site_url($locale . '/admin/users/subscriptions/form/' . $id) ?>', '<?= $id ?>');
		$("#ModalFormSecondary").modal('show');
		
		retrieveAjaxListData(urlListString);
	});
	<?php endif; ?>
	
	////// form submit //////
	$(document).on('click', '.submit-button', function() {

		// attention: use this to save ckeditor content **//
		$.each( CKEDITOR.instances, function(instance) {
			var editor_data = CKEDITOR.instances[instance].getData();
			$('#' + instance).html(editor_data);      
		});
		
		if (!validateInputs()) {
				console.log('validateInputs = false!!!');
				// Return false or handle invalid form
		}

		form_data = $('#form').serialize();
		var ajaxUrl = $('#form').attr('action');
		$('#modal-secondary-success').hide();

		$.post(ajaxUrl, form_data, function(response) {
			if (typeof response != "object") {
				alert('communication error');
				return;
			}

			if (response.status == 'success') {
				
				$('#modal-secondary-success').removeClass('d-none');
				$('#modal-secondary-success').show();
				$('#modal-secondary-success-message').html(response.data.message);
				$('#modal-secondary-error').hide();

			} else if (response.status == 'error') {
				var error_message = '';
				$.each( response.data.error_message, function( key, value ) {
					error_message += '<p class="p-0 m-0">' + value + '</p>';
				});
				$('#modal-secondary-error-message').html(error_message);
				$('#modal-secondary-error').removeClass('d-none');
				$('#modal-secondary-error').show();
			}
			
			retrieveAjaxListData(urlListString);
			
			//assign last inserted id to the form
			$('#form').attr('action', '<?= site_url($locale . '/admin/users/subscriptions/form_submit') ?>/' + response.data.id);
			
			//change the url string
			var url = new URL('<?= site_url($locale . '/admin/users/subscriptions/form') ?>/' + response.data.id);
			window.history.pushState(null, '', url.toString());
			
			$('.modal-body').animate({ scrollTop: 0 }, 'slow');
			
		}, 'json');
	});
// put functions inside this
});
</script>
