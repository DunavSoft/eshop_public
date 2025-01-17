<script>
	var lastEditedId = 0;

	var urlListString = '<?= site_url($locale . '/admin/properties/' . $page) ?>';

	//click on edit button
	$(document).on('click', '.edit-button', function(event) {

		event.preventDefault();

		var ajaxUrl = $(this).attr('href');
		var id = $(this).attr('data-id');

		if (lastEditedId == id && lastEditedId != 'new') {
			console.log('properties_js - return from edit-button');
			retrieveAjaxFormData(ajaxUrl, id);
			return;
		}

		lastEditedId = id;

		//get form data
		retrieveAjaxFormData(ajaxUrl, id);
	});

	//close modal event
	$(document).ready(function() {
		$("#ModalFormSecondary").on('hide.bs.modal', function() {
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

	<?php if ($isNotAjaxRequest) : ?>
		$(document).ready(function() {
			retrieveAjaxFormData('<?= site_url($locale . '/admin/properties/form/' . $id . '/' . $duplicate) ?>', '<?= $id ?>');
			$("#ModalFormSecondary").modal('show');

			retrieveAjaxListData('<?= site_url($locale . '/admin/properties/' . $page) ?>');
		});
	<?php endif; ?>

	////// form submit //////
	$(document).on('click', '.submit-button', function() {

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
				$.each(response.data.error_message, function(key, value) {
					error_message += '<p class="p-0 m-0">' + value + '</p>';
				});
				$('#modal-secondary-error-message').html(error_message);
				$('#modal-secondary-error').removeClass('d-none');
				$('#modal-secondary-error').show();
			}

			retrieveAjaxListData(urlListString);

			//assign last inserted id to the form
			$('#form').attr('action', '<?= site_url($locale . '/admin/properties/form_submit') ?>/' + response.data.id);

			//change the url string
			var url = new URL('<?= site_url($locale . '/admin/properties/form') ?>/' + response.data.id);
			window.history.pushState(null, '', url.toString());

			$('.modal-body').animate({
				scrollTop: 0
			}, 'slow');

		}, 'json');
	});

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
		//alert('Type: ' + input.attr('type') + 'Id: ' + input.attr('id') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());

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
		//alert('Type: ' + input.attr('type') + 'Id: ' + input.attr('id') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());

		var data = {
			fieldName: input.attr('name'),
			fieldValue: input.val(),
			fieldId: input.attr('id'),
		};

		$.post('<?= site_url($locale . '/admin/properties/validate_field') ?>', data, function(response) {

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

	$(document).on('submit', '#search_form', function(event) {
		event.preventDefault();
	});

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

	function retrieveAjaxListData(ajaxUrl) {

		//$('#ajax-content').html('<?= str_replace(array("\r\n", "\n", "\r"), '', lang('AdminPanel.modal_spinner')) ?>');

		$.get(ajaxUrl, function(response) {
			$('#ajax-content').html(response);
		});
	}

	//search 
	$(document).on('click', '#top-search-button', function() {
		search_ajax();
	});

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

	$(document).on('submit', '#search_form', function(event) {
		event.preventDefault();
	});

	$('#top-search-text').keyup(function(e) {

		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;

		var strlen = $('#top-search-text').val().length;

		if (strlen == 0) {
			retrieveAjaxListData(urlListString);
		}

		if (key == 13 || strlen > 2) {
			search_ajax();
		}
	});

	function search_ajax() {

		form_data = $('#search_form').serialize();

		$.post('<?= site_url($locale . '/admin/properties/search') ?>', form_data, function(response) {
			$('#ajax-content').html(response);
		});
	}


	//slug 
	var uriLenght = <?= strlen(site_url()); ?>

	function checkSlugLenght(value, id) {
		if (value == '') {
			$('#feedback_' + id).hide();
			return;
		}

		if (value.length + uriLenght > <?= $uriWarningLength ?>) {
			$('#feedback_' + id).show();
			$('#' + id).addClass('is-warning');
		} else {
			$('#feedback_' + id).hide();
			$('#' + id).removeClass('is-warning');
		}
	}

	$(document).on('keyup', '.slug', function() {
		//checkSlugLenght(this.value, this.id);
		getSlug(this.value, this.id);
	});
	$(document).on('change', '.slug', function() {
		//getSlug(this.value, this.id);
		//checkSlugLenght(this.value, this.id);
	});

	$(document).on('keyup', '.title-validation', function() {
		getSlug(this.value, this.id);
	});


	$(document).ready(function() {
		//alert('doc ready');
		$('.slug').each(function() {
			//alert(this.value);
			//checkSlugLenght(this.value, this.id);
		});
	});

	//check for change slug if page exists
	<?php if ($id != 'new') : ?>
		const oldValuesArray = {};
		$('.slug').each(function() {
			oldValuesArray[this.id] = this.value;
		});

		var changedSlugId = '';
		$('.slug').change(function() {
			//checkSlugLenght(this.value, this.id);
			//$('#ModalConfirmSlug').show();
			changedSlugId = this.id;
			$('#ModalConfirmSlug').modal('show');
		});

		function getSlug(inputValue, inputId) {

			var lang_id = inputId.replace('title', '');
			lang_id = lang_id.replace('slug', '');

			//alert(lang_id);
			var lang_field_id = $('input[name="properties_languages[' + lang_id + '][id]"]').val();

			var input_origin = inputId.replace(lang_id, '');

			if (input_origin == 'title' && lang_field_id != '' && lang_field_id != 'undefined') {
				return;
			}

			var data = {
				inputString: inputValue,
				id: lang_field_id,
				lang_id: lang_id
			};

			$.post('<?= site_url($locale . '/admin/properties/create_slug') ?>', data, function(response) {
				if (response.status == 'success') {

					$('#slug' + lang_id).val(response.slug);

					checkSlugLenght(response.slug, 'slug' + lang_id);
				} else {
					//do not touch
				}
			}, 'json');
		}

		// later:
		/*
		$.each(oldValuesArray, function (index, value) {
		    alert( index + ' : ' + value );
		});
		*/

		//alert(oldValuesArray['slug4']);

	<?php endif; ?>
</script>