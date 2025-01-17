<?= form_open($locale . '/admin/redirects/form_submit/' . $id, 'id="form" role="form" class="needs-validation"') ?>
<!-- Main content -->

  <div class="container-fluid p-0">  
  
   <!-- /.card -->
	<div class="card card-primary card-outline rounded-0">
	  <div class="card-body">
	  
	  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
		  <li class="nav-item">
			<a class="nav-link active" id="custom-content-below-content-tab" data-toggle="pill" href="#custom-content-below-content" role="tab" aria-controls="custom-content-below-content" aria-selected="true"><?php echo lang('AdminPanel.content');?></a>
		  </li>
		<?php /*
		  <li class="nav-item">
			<a class="nav-link" id="custom-content-below-attributes-tab" data-toggle="pill" href="#custom-content-below-attributes" role="tab" aria-controls="custom-content-below-attributes" aria-selected="false"><?php echo lang('AdminPanel.attributes');?></a>
		  </li>
		  */ ?>
		  <?php if ($id != 'new'):?>
		  <li class="nav-item">
			<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info');?></a>
		  </li>
		   <?php endif;?>
		</ul>
		
		<div class="tab-content" id="custom-content-below-tabContent">
		  <div class="tab-pane fade show active" id="custom-content-below-content" role="tabpanel" aria-labelledby="custom-content-below-content-tab">

			<span class="form-horizontal">
			  <div class="card-body">
				<div class="form-group row">
				  <label for="source" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('RedirectsLang.source');?> <?= isset($validationRules['source-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					$data = [ 
						'id' => 'source',
						'name' => 'redirects[source]',
						'value' => set_value('redirects[source]', $source ?? ''),
						'class' => 'form-control',
						'placeholder' => lang('RedirectsLang.sourceHelp'),
						//'data-error' => lang('Validation.required', []),
					];
					
					isset ($validationRules['source-required']) ? 
					$data['required'] = $validationRules['source-required'] : '';
					
					echo form_input($data);
					?>
				  </div>
				</div>
				
				<div class="form-group row">
				  <label for="code" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('RedirectsLang.code');?> <?= isset($validationRules['code-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					isset ($validationRules['code-required']) ? 
					$data['required'] = $validationRules['code-required'] : '';
					
					echo form_dropdown('redirects[code]', $config->arrayHTTPCodes, $code, 'class="form-control"');
					?>
				  </div>
				</div>
				
				<div class="form-group row">
				  <label for="target" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('RedirectsLang.target');?> <?= isset($validationRules['target-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					$data = [ 
						'id' => 'target',
						'name' => 'redirects[target]',
						'value' => set_value('redirects[target]', $target ?? ''),
						'class' => 'form-control',
						'placeholder' => lang('RedirectsLang.targetHelp'),
						'data-error' => 'Field is required.',
					];
					
					isset ($validationRules['target-required']) ? 
					$data['required'] = $validationRules['target-required'] : '';
					
					echo form_input($data);
					?>
				  </div>
				</div>
			  </div>
			</span>
		  </div>

		  <div class="tab-pane fade" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
			<span class="form-horizontal">
			  <div class="card-body">
				<div class="form-group row">
				  <label for="created_at" class="col-sm-2 text-start text-sm-right"><?=lang('AdminPanel.createdAt')?></label>
				  <div class="col-sm-10">
					<?php echo date('d.m.Y H:i', $created_at); ?>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="updated_at" class="col-sm-2 text-start text-sm-right"><?=lang('AdminPanel.updatedAt')?></label>
				  <div class="col-sm-10">
					<?php echo date('d.m.Y H:i', $updated_at); ?>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="count_usage" class="col-sm-2 text-start text-sm-right"><?= lang('RedirectsLang.count_usage')?></label>
				  <div class="col-sm-10">
					<?= $count_usage ?>
				  </div>
				</div>
				
			  </div>
			</span>
		  </div>
		</div>
		
		  <div class="row mt-0 mb-2">
			<div class="col-sm-12 text-center">
			  <div class="btn-group">
				<input class="btn btn-primary submit-button" type="button" value="<?=lang('AdminPanel.save')?>" />
				<button class="btn btn-light" type="button" data-tooltip="tooltip" title="<?= lang('AdminPanel.close') ?>" data-dismiss="modal">&times;</button>
			  </div>
			</div>
		  </div>
		  
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.card -->
	</div>
  <!-- /.container-fluid -->

<?= form_close() ?>

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