<?= form_open($locale . '/admin/users/subscriptions/form_submit/' . $id, 'id="form" role="form" class="needs-validation"') ?>
<!-- Main content -->

  <div class="container-fluid p-0">
  
   <!-- /.card -->
	<div class="card card-primary card-outline rounded-0">
	  <div class="card-body">
	  
	  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">

		  <li class="nav-item">
				<a class="nav-link active" id="custom-content-below-attributes-tab" data-toggle="pill" href="#custom-content-below-attributes" role="tab" aria-controls="custom-content-below-attributes" aria-selected="true"><?= lang('AdminPanel.attributes') ?></a>
		  </li>
		 
		  <?php if ($id != 'new'):?>
		  <li class="nav-item">
				<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info');?></a>
		  </li>
		  <?php endif;?>
		</ul>
		
		<div class="tab-content" id="custom-content-below-tabContent">
		  
		  <div class="tab-pane fade show active" id="custom-content-below-attributes" role="tabpanel" aria-labelledby="custom-content-below-attributes-tab">
			<span class="form-horizontal">
			  <div class="card-body">

				<div class="form-group row">
					<label for="email" class="col-sm-2 col-form-label text-left text-sm-right"><?php echo lang('AdminPanel.email');?><?= isset($validationRulesPrimary['email-required']) ? ' <span class="text-danger">*</span>' : '' ?></label>
					<div class="col-sm-4">
						<?php
						$data = [ 'id' => 'email', 'name' => 'subscriptions[email]', 'value' => set_value('subscriptions[email]', $email ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.email'), 'readonly' => true ];
						echo form_input($data);
						?>
						<div class="invalid-feedback" id="feedback_email"></div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="name" class="col-sm-2 col-form-label text-left text-sm-right"><?php echo lang('SubscriptionsLang.name');?></label>
					<div class="col-sm-4">
						<?php
						$data = [ 'id' => 'name', 'name' => 'subscriptions[name]', 'value' => set_value('subscriptions[name]', $name ?? ''), 'class' => 'form-control', 'placeholder' => lang('SubscriptionsLang.name') ];
						echo form_input($data);
						?>
						<div class="invalid-feedback" id="feedback_email"></div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="phone" class="col-sm-2 col-form-label text-left text-sm-right"><?php echo lang('SubscriptionsLang.phone');?></label>
					<div class="col-sm-4">
						<?php
						$data = [ 'id' => 'phone', 'name' => 'subscriptions[phone]', 'value' => set_value('subscriptions[phone]', $phone ?? ''), 'class' => 'form-control', 'placeholder' => lang('SubscriptionsLang.phone') ];
						echo form_input($data);
						?>
						<div class="invalid-feedback" id="feedback_email"></div>
					</div>
				</div>
				
				<div class="form-group row">
				  <label for="active" class="col-sm-2 col-form-label text-left text-sm-right"><?php echo lang('AdminPanel.active');?><?= isset($validationRules['active-required']) ? ' <span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-4">
					<?php
					$options = [
						1 => lang('AdminPanel.yes'),
						0 => lang('AdminPanel.no'),
					];
					echo form_dropdown('subscriptions[active]', $options, set_value('subscriptions[active]', $active), 'class="form-control"');
					?>
					<div class="invalid-feedback" id="feedback_active"></div>
				  </div>
				</div>
				
			  </div>
			</span>
		  </div>
		  
		  
		  <div class="tab-pane fade" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
			<span class="form-horizontal">
			  <div class="card-body">
				<div class="form-group row">
				  <label for="created_at" class="col-sm-2 text-left text-sm-right"><?=lang('AdminPanel.createdAt')?></label>
				  <div class="col-sm-10">
					<?php echo date('d.m.Y H:i', $created_at); ?>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="updated_at" class="col-sm-2 text-left text-sm-right"><?=lang('AdminPanel.updatedAt')?></label>
				  <div class="col-sm-10">
					<?php echo date('d.m.Y H:i', $updated_at); ?>
				  </div>
				</div>
			  </div>
			</span>
		  </div>
		  
		  
		</div>
		
		  <div class="row mt-0 mb-2">
			<div class="col-sm-12 text-center">
			  <div class="btn-group">
				<input class="btn btn-primary submit-button" type="button" value="<?= lang('AdminPanel.save') ?>" />
				<button class="btn btn-light" type="button" data-dismiss="modal" data-tooltip="tooltip" title="<?= lang('AdminPanel.close') ?>">&times;</button>
			  </div>
			</div>
		  </div>
		  
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.card -->
	</div>
  <!-- /.container-fluid -->

<?=form_close()?>

<?php
if (isset($form_js)) {
	try
	{
		if (is_array($form_js)) {
			foreach ($form_js as $js) {
				echo view($js);
			}
		} else {
			echo view($form_js);
		}
	}
	catch (Exception $e)
	{
		echo "<pre><code>$e</code></pre>";
	}
}
?>