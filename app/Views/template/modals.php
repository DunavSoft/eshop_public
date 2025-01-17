<script>
	var url = '';
	var ajaxUrl = '';
	$(document).on('click', '.delete-button, .archive-button', function(event) {

		event.preventDefault();
		url = $(this).attr('href');
		ajaxUrl = $(this).attr('data-ajax-url');
	});

	$(document).on('click', '.confirm-delete-button', function() {
		processUrl(url);

		$("#ModalConfirmAjax").modal('hide');

	});

	$(document).on('click', '.confirm-archive-button', function() {
		processUrl(url);

		$("#ModalConfirmArchive").modal('hide');

	});

	$(document).on('click', '.process-button', function(event) {

		event.preventDefault();
		url = $(this).attr('href');

		processUrl(url);

	});

	function processUrl(url) {
		$.get(url, function(response) {
			if (response.status == 'success') {
				$('#error').hide();
				$('#success').removeClass('d-none');
				$('#success').show();
				$('#success-message').html(response.data.message);

				$('#row' + response.data.id).remove();
			} else {
				$('#success').hide();
				$('#error-message').html(response.data.error_message);
				$('#error').removeClass('d-none');
				$('#error').show();
			}
		}, 'json');
	}
</script>

<div class="modal fade" id="ModalConfirmAjax" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= lang('AdminPanel.areYouSure'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang('AdminPanel.close'); ?></button>
				<button class="btn btn-danger confirm-delete-button" type="button"><?= lang('AdminPanel.yes'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalConfirmArchive" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= lang('OrdersLang.areYouSureArchive'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang('AdminPanel.close'); ?></button>
				<button class="btn btn-danger confirm-archive-button" type="button"><?= lang('AdminPanel.yes'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalError" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= lang('AdminPanel.error'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-danger" id="ModalErrorMessage">

			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang('AdminPanel.close'); ?></button>
			</div>
		</div>
	</div>
</div>


<script>
	var idToProcess;

	$(".button-process").on('click', function() {
		//alert($(this).attr("data-func"));
		//alert($(this).attr("data-id"));

		idToProcess = $(this).attr("data-id");

		if ($(this).attr("data-func") == 'deassign') {
			$('#button-modal-slug-yes').attr('onclick', 'deassign(' + idToProcess + ')');
		}

		if ($(this).attr("data-func") == 'assign') {
			$('#button-modal-slug-yes').attr('onclick', 'assign(' + idToProcess + ')');
		}
	});
</script>

<div class="modal fade" id="ModalConfirmAssign" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?= lang('AdminPanel.areYouSure'); ?></h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>
			<div class="modal-footer">
				<button id="button-modal-slug-no" class="btn btn-primary" type="button" data-dismiss="modal"><?= lang('AdminPanel.no'); ?></button>
				<button id="button-modal-slug-yes" class="btn btn-danger" type="button"><?= lang('AdminPanel.yes'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalFormSecondary" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog full_modal_dialog modal-dialog-scrollable" role="document">
		<div class="modal-content full_modal_content">
			<div class="modal-header">
				<h4><a href="javascript:" data-dismiss="modal" data-tooltip="tooltip" title="<?= lang('AdminPanel.back') ?>"><i class="fa fa-arrow-left"></i></a></h4>
				<h4 id="modal-secondary-title" class="modal-title"></h4>

				<div class="btn-group float-right">
					<button class="btn btn-primary save-button submit-button" type="button"><?= lang('AdminPanel.save') ?></button>
					<button class="btn btn-light" type="button" data-dismiss="modal" data-tooltip="tooltip" title="<?= lang('AdminPanel.close') ?>">&times;</button>
				</div>

			</div>
			<div class="modal-body p-0">
				<div id="modal-secondary-success" class="m-3 alert alert-success alert-dismissible fade show d-none" role="alert">
					<span id="modal-secondary-success-message"></span>
					<button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div id="modal-secondary-error" class="m-3 alert alert-danger fade show d-none" role="alert">
					<span id="modal-secondary-error-message"></span>
				</div>

				<span id="modal-form-secondary">
					<?= str_replace(array("\r\n", "\n", "\r"), '', lang('AdminPanel.modal_spinner')) ?>
				</span>
			</div>
		</div>
	</div>
</div>