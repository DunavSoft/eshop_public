<div class="card-body <?php if ($nrImages > 0):?>bg-white<?php else:?>bg-light<?php endif;?> border m-1" id="image_card<?= $nrImages ?>" style="opacity:0.95">

	<?php $i = 0; foreach ($languagesSite as $language): $i++;?>
	
	<?php $imagesDesc = json_decode($moduleLanguages[$language->id]->images_description ?? ''); ?>
	<?php //d($imagesDesc); ?>

	<div class="form-group row">
		<label for="img_alt<?php echo $language->id;?>" class="col-sm-2 col-form-label text-start text-sm-right">
			<?php if ($i == 1):?><i class="fa-solid fa-arrows-up-down handle" style="color: white; background-color: #004080; padding: 6px;padding-left: 10px;padding-right: 10px; border-radius: 3px;"></i> <?php endif;?><?php echo lang('AdminPanel.imgAlt');?> <?php echo $language->native_name?></label>
		<div class="col-sm-3">
			<?php
				$data = [
					'id' => 'img_alt' . $language->id . $nrImages, 
					'name' => 'images_desc['. $language->id .']['. $nrImages .'][img_alt]', 
					'value' => set_value('images_desc['. $language->id .']['. $nrImages .'][img_alt]', $imagesDesc[$nrImages - 1]->img_alt ?? ''), 
					'class' => 'form-control', 
					'placeholder' => lang('AdminPanel.imgAlt') 
				];
				echo form_input($data);
			?>
		</div>			  
		<label for="img_title<?php echo $language->id;?>" class="col-sm-2 col-form-label text-start text-sm-right"><?php echo lang('AdminPanel.imgTitle');?> <?php echo $language->native_name?></label>
		<div class="col-sm-3">
			<?php
				$data = [ 
					'id' => 'img_title' . $language->id . $nrImages, 
					'name' => 'images_desc['. $language->id .']['. $nrImages .'][img_title]', 
					'value' => set_value('images_desc['. $language->id .']['. $nrImages .'][img_title]', $imagesDesc[$nrImages - 1]->img_title ?? ''), 
					'class' => 'form-control', 
					'placeholder' => lang('AdminPanel.imgTitle') 
				];
				echo form_input($data);
			?>
		</div>  
	</div>
	<?php endforeach;?>
	
	<div class="form-group row">
	  <label for="upload_image<?= $nrImages ?>" class="col-sm-2 col-form-label text-start text-sm-right <?php if ($nrImages > 0):?>d-none<?php endif;?>"><?=lang('AdminPanel.image')?></label>
	  <div class="image-editor col-sm-10 <?php if ($nrImages > 0):?>d-none<?php endif;?>" id="image_container<?= $nrImages ?>">
		<span><?php echo form_upload([ 'id' => 'upload_image' . $nrImages, 'name' => 'upload_image', 'class' => 'form-control cropit-image-input', 'accept' => '.jpg, .jpeg, .png' ]);?></span>
		
		<?php if ($config->useCropImages):?>
			<small class="form-text text-muted"><?= lang('CommonLang.image_size') ?><?= $config->cropWidth * $config->cropExportZoom ?> x <?= $config->cropHeight * $config->cropExportZoom ?> px.</small>
			
			<div class="cropit-preview"></div>
			
			<input type="range" class="cropit-image-zoom-input">
			
			<p><a href="javascript:" class="submit-cropit btn btn-primary disabled"><?= lang('CommonLang.Upload') ?></a> <span id="dont_forget_to_upload" class="text-danger d-none"><?= lang('CommonLang.dont_forget_to_upload') ?></span></p>
		<?php endif;?>
	  </div>

	  <label for="image" class="col-sm-2 col-form-label image_container text-start text-sm-right <?php if ($nrImages == 0):?>d-none<?php endif;?>"><?=lang('AdminPanel.currentImage')?></label>
	  <div class="col-sm-10 image_container <?php if ($nrImages == 0):?>d-none<?php endif;?>">
		<img id="current_image<?= $nrImages ?>" height="<?=$config->cropHeight?>" <?php if ($nrImages > 0):?>src="<?php echo $image->image;?>"<?php endif;?>>
		
		<a class="btn btn-danger btn-sm" href="javascript:" id="remove_button<?=$nrImages?>" onclick="removeImage(this.id);" >
		  <i class="fas fa-trash" data-tooltip="tooltip" title="<?=lang('AdminPanel.delete')?>"></i>
		</a>
		
		<?php if ($nrImages == 0):?>
			<?php $data = [ 'type' => 'hidden', 'id' => 'image' . $nrImages, 'value' => '' ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'sorting_image' . $nrImages, 'name' => 'sorting_images[]', 'value' => '' ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'galleries_img'. $nrImages, 'value' => '' ];
			echo form_input($data);?>
		<?php endif;?>
		
		<?php if ($nrImages > 0):?>
			<?php $data = [ 'type' => 'hidden', 'id' => 'galleries_img'. $nrImages, 'name' => $images_table_name . '['. $nrImages .'][id]', 'value' => set_value($images_table_name . '['. $nrImages .'][id]', (string)$image->id ?? '' ) ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'sorting_image'. $nrImages, 'name' => 'sorting_images[]', 'value' => (string)$nrImages ?? '0' ];
			echo form_input($data);?>
		<?php endif;?>
	  </div>
	</div>
</div>