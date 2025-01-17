<?= form_open($locale . '/admin/properties/form_submit/' . $id, 'id="form" role="form" class="needs-validation"') ?>
<!-- Main content -->

  <div class="container-fluid p-0">
   <!-- /.card -->
	<div class="card card-primary card-outline rounded-0">
	  <div class="card-body">
	  
	  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
		<?php $i = 0; foreach ($languagesSite as $language): $i++;?>
		  <li class="nav-item">
			<a class="nav-link <?php if ($i == 1):?>active<?php endif;?>" id="custom-content-below-content-tab<?php echo $language->id?>" data-toggle="pill" href="#custom-content-below-content<?php echo $language->id?>" role="tab" aria-controls="custom-content-below-content<?php echo $language->id?>" <?php if ($i == 1):?>aria-selected="true"<?php endif;?>><?php echo $language->native_name?></a>
		  </li>
		<?php endforeach;?>

		  <li class="nav-item">
			<a class="nav-link" id="custom-content-below-attributes-tab" data-toggle="pill" href="#custom-content-below-attributes" role="tab" aria-controls="custom-content-below-attributes" aria-selected="false"><?php echo lang('AdminPanel.attributes');?></a>
		  </li>

		  <li class="nav-item">
			<a class="nav-link" id="custom-content-below-image-tab" data-toggle="pill" href="#custom-content-below-image" role="tab" aria-controls="custom-content-below-image" aria-selected="false"><?php echo lang('AdminPanel.images');?></a>
		  </li>
		 
		  <?php if ($id != 'new'):?>
		  <li class="nav-item">
			<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info');?></a>
		  </li>
		   <?php endif;?>
		</ul>
		
		<div class="tab-content" id="custom-content-below-tabContent">
		<?php $i = 0; foreach ($languagesSite as $language): $i++;?>
		  <div class="tab-pane fade <?php if ($i == 1):?>show active<?php endif;?>" id="custom-content-below-content<?php echo $language->id;?>" role="tabpanel" aria-labelledby="custom-content-below-content-tab<?php echo $language->id;?>">
		  
			<?php
			if ($id != 'new') {
				echo form_hidden('properties_languages['. $language->id .'][id]', $propertiesLanguages[$language->id]->id ?? '');
			} else {
				echo form_hidden('properties_languages['. $language->id .'][id]', '');
			}
			?>
			
			<span class="form-horizontal">
			  <div class="card-body">
				<div class="form-group row">
				  <label for="title<?= $language->id ?>" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('AdminPanel.title');?> <?= isset($validationRules['title-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					$data = [ 
						'id' => 'title' . $language->id,
						'name' => 'properties_languages['. $language->id .'][title]',
						'value' => set_value('properties_languages['. $language->id .'][title]', $propertiesLanguages[$language->id]->title ?? '', false),
						'class' => 'form-control title-validation',
						'placeholder' => lang('AdminPanel.title'),
						'data-error' => 'Field is required.',
					];
					
					isset ($validationRules['title-required']) ? 
					$data['required'] = $validationRules['title-required'] : '';
					
					echo form_input($data);
					?>
					
					<div class="invalid-feedback" id="feedback_title<?= $language->id ?>"></div>
					
				  </div>
				</div>
				
				<?php /*
				<div class="form-group row">
				  <label for="slug<?php echo $language->id;?>" class="col-sm-2 col-form-label text-right"><?php echo lang('AdminPanel.slug');?> <?= isset($validationRules['slug-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
						$data = [
							'id' => 'slug' . $language->id, 
							'name' => 'properties_languages['. $language->id .'][slug]',
							'value' => set_value('properties_languages['. $language->id .'][slug]', $propertiesLanguages[$language->id]->slug ?? '', false),
							'class' => 'form-control slug',
							'placeholder' => lang('AdminPanel.slug'),
						];
						echo form_input($data);
					?>
					
					<div class="warning-feedback" id="feedback_slug<?=$language->id?>">
						<?php echo lang('AdminPanel.slugLenghtWarningQuestion');?>
					</div>
			
				  </div>
				</div>
				*/ ?>
				
				<?php if ($config->useDescription) : ?>
				<!-- content -->
			    <hr />
				<?php
				
					$data = [
						'name' => 'properties_languages['. $language->id .'][content]',
						'value' => $propertiesLanguages[$language->id]->content ?? '',
						'class' => 'ckeditor'
					];
					
					echo form_textarea($data);
				?>
				<hr />
				<?php endif; ?>
				
			  </div>
			</span>
			
		  </div>
		  
		   <?php endforeach;?>
		  
		  <div class="tab-pane fade" id="custom-content-below-attributes" role="tabpanel" aria-labelledby="custom-content-below-attributes-tab">
			<span class="form-horizontal">
			  <div class="card-body">

				<div class="form-group row">
				  <label for="active" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('AdminPanel.active');?><?= isset($validationRulesPrimary['active-required']) ? ' <span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					$options = [
						1 => lang('AdminPanel.yes'),
						0 => lang('AdminPanel.no'),
					];
					echo form_dropdown('properties[active]', $options, set_value('properties[active]', $active), 'class="form-control" id="active"');
					?>
					<div class="invalid-feedback" id="feedback_active"></div>
				  </div>
				</div>
				
				<div class="form-group row">
					<label for="category_id" class="col-sm-2 col-form-label text-start text-sm-right">
						<?= lang('PropertiesLang.category') ?>
						<?= isset($validationRulesPrimary['category_id-required']) ? ' <span class="text-danger">*</span>' : '' ?>
					</label>

					<div class="col-sm-10">
						<?php
						$options = [
							'' => lang('PropertiesLang.select'),
						];

						foreach ($categories as $category) {
							$options[$category->id] = $category->title;
						}

						echo form_dropdown(
							'properties[category_id]',
							$options,
							set_value('properties[category_id]', $category_id ? $category_id : 0),
							'class="form-control" id="category_id"'
						);
						?>
						<div class="invalid-feedback" id="feedback_category_id"></div>
					</div>
				</div>

				<div class="form-group row">
				  <label for="sequence" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('AdminPanel.sequence');?> <?= isset($validationRules['sequence-required']) ? '<span class="text-danger">*</span>' : '' ?></label>
				  <div class="col-sm-10">
					<?php
					$data = [ 
						'id' => 'sequence',
						'name' => 'properties[sequence]',
						'value' => set_value('properties[sequence]', $sequence ?? '10'),
						'class' => 'form-control sequence-validation',
						'placeholder' => lang('AdminPanel.sequence'),
					];
					
					echo form_input($data);
					?>
					<div class="invalid-feedback" id="feedback_sequence"></div>
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
			  </div>
			</span>
		  </div>
		  
		  <!-- images multiupload tab -->
		  <div class="tab-pane fade" id="custom-content-below-image" role="tabpanel" aria-labelledby="custom-content-below-image-tab">		
			<?php

				$passArray['nrImages'] = 0;
				$passArray['image'] = [];

				echo view('\App\Modules\Common\ImageMultiUpload\Views\images_multiupload_form', $passArray);

			?>
			</span>
			
			<a class="btn btn-danger btn-sm" href="javascript:" id="remove-all-images-button">
			  <?= lang('CommonLang.image_delete_all') ?> <i class="fas fa-trash"></i>
			</a>
			
			<p class="pt-0 pb-0 mb-0 mt-0"><small id="ordering_help"><?= lang('CommonLang.ordering_help') ?></small></p>

			<span class="form-horizontal" id="images_sortable">
			<span id="image_card_sortable"></span>

			<?php foreach ($imagesArray as $image) {
				$passArray['nrImages']++;
				$passArray['image'] = $image;
				echo view('\App\Modules\Common\ImageMultiUpload\Views\images_multiupload_form', $passArray);
			} ?>
			</span>			
		  </div>
		  <!-- end images multiupload tab -->
		  
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

<script>
//this script is to allow click on the additional fields in ckfinder (links, tables etc.)
$(document).ready(function () {
    $('#ModalFormSecondary').on('shown.bs.modal', function () {
        $(document).off('focusin.modal');
    });

    if ($('#ModalFormSecondary').hasClass('show')) {
        $(document).off('focusin.modal');
    }
});
</script>