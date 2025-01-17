<script type="text/javascript">
var a;
function areyousure(id) {
	if (id != 0) {
		a = $('#button_id' + id).attr('href');
	}
	
	if (id == 0) {
		$(location).attr('href', a);
	}
}
</script>

<div class="modal fade" id="ModalConfirm" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
			    <h5 class="modal-title"><?=lang('AdminPanel.areYouSure');?></h5>
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			     	<span aria-hidden="true">&times;</span>
			    </button>
		    </div>
	      	<div class="modal-footer">
	        	<button class="btn btn-secondary" type="button" data-dismiss="modal"><?=lang('AdminPanel.close');?></button>
	        	<button class="btn btn-danger" type="button" onclick="areyousure(0);"><?=lang('AdminPanel.yes');?></button>
	      	</div>
	    </div>
  	</div>
</div>


<div class="modal fade" id="ModalError" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
			    <h5 class="modal-title"><?=lang('AdminPanel.error');?></h5>
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			     	<span aria-hidden="true">&times;</span>
			    </button>
		    </div>
		    <div class="modal-body text-danger" id="ModalErrorMessage">
		      	
	      	</div>
	      	<div class="modal-footer">
	        	<button class="btn btn-secondary" type="button" data-dismiss="modal"><?=lang('AdminPanel.close');?></button>
	      	</div>
	    </div>
  	</div>
</div>


<script>
var a;
function areyousureSlug() {
	$('#' + changedSlugId).val(oldValuesArray[changedSlugId]);
	$('#ModalConfirmSlug').modal('hide');
}
</script>

<div class="modal fade" id="ModalConfirmSlug" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
			    <h5 class="modal-title"><?=lang('AdminPanel.areYouSure');?></h5>
				<!--
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			     	<span aria-hidden="true">&times;</span>
			    </button>
				-->
		    </div>
	      	<div class="modal-footer">
	        	<button class="btn btn-warning" type="button" data-dismiss="modal"><?=lang('AdminPanel.yes');?></button>
	        	<button class="btn btn-primary" type="button" onclick="areyousureSlug();"><?=lang('AdminPanel.not');?></button>
	      	</div>
	    </div>
  	</div>
</div>