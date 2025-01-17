<div class="card-body <?php if ($nrImages > 0):?>bg-white<?php else:?>bg-light<?php endif;?> border m-1" id="image_card<?=$nrImages?>" style="opacity:0.95">

	<?php $i = 0; foreach ($languages as $language): $i++;?>
	
	<?php $imagesDesc = json_decode($galleriesLanguages[$language->id]->images_description ?? ''); ?>

	<div class="form-group row">
		<label for="img_alt<?= $language->id;?>" class="col-sm-2 col-form-label">
			<?php if ($i == 1):?><i class="fa-solid fa-arrows-up-down handle" style="color: white; background-color: #004080; padding: 6px;padding-left: 10px;padding-right: 10px; border-radius: 3px;"></i> <?php endif;?><?= lang('AdminPanel.imgAlt');?> <?= $language->native_name?></label>
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
		<label for="img_title<?= $language->id;?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.imgTitle');?> <?= $language->native_name?></label>
		<div class="col-sm-5">
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
	  <label for="upload_image<?=$nrImages?>" class="col-sm-2 col-form-label <?php if ($nrImages > 0):?>d-none<?php endif;?>"><?=lang('AdminPanel.image')?></label>
	  <div class="image-editor col-sm-10 <?php if ($nrImages > 0):?>d-none<?php endif;?>" id="image_container<?=$nrImages?>">
		<?php if ($config->useCropImages != true):?>
		<span><?= form_upload([ 'id' => 'upload_image' . $nrImages, 'name' => 'upload_image', 'class' => 'form-control cropit-image-input', 'accept' => '.jpg, .jpeg, .png', 'multiple' => 'multiple' ]);?></span>
		<?php else: ?>
		<span><?= form_upload([ 'id' => 'upload_image' . $nrImages, 'name' => 'upload_image', 'class' => 'form-control cropit-image-input', 'accept' => '.jpg, .jpeg, .png' ]);?></span>
		<?php endif; ?>
		
		<?php if ($config->useCropImages):?>
			<div class="cropit-preview"></div>
			
			<input type="range" class="cropit-image-zoom-input">
			<p><a href="javascript:" class="submit-cropit btn btn-primary disabled"><?= lang('GalleriesLang.Upload') ?></a> <span id="dont_forget_to_upload" class="text-danger d-none"><?= lang('GalleriesLang.dont_forget_to_upload') ?></span></p>
		<?php endif;?>
	  </div>

	  <label for="image" class="col-sm-2 col-form-label image_container <?php if ($nrImages == 0):?>d-none<?php endif;?>"><?=lang('AdminPanel.currentImage')?></label>
	  <div class="col-sm-10 image_container <?php if ($nrImages == 0):?>d-none<?php endif;?>">
		<img id="current_image<?=$nrImages?>" height="<?=$config->cropHeight?>" <?php if ($nrImages > 0):?>src="<?= isset($image->image) ? $image->image : $image['image'];?>"<?php endif;?>>
		
		<a class="btn btn-danger btn-sm" href="javascript:" id="remove_button<?=$nrImages?>" onclick="removeImage(this.id);" >
		  <i class="fas fa-trash" data-tooltip="tooltip" title="<?=lang('AdminPanel.deleteImage')?>"></i>
		</a>
		
		<?php if ($nrImages == 0):?>
			<?php $data = [ 'type' => 'hidden', 'id' => 'image' . $nrImages, 'value' => set_value('galleries_images['. $nrImages .'][image]', '' ) ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'sorting_image' . $nrImages, 'name' => 'sorting_images[]', 'value' => '' ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'galleries_img'. $nrImages, 'value' => '' ];
			echo form_input($data);?>
		<?php endif;?>
		
		<?php if ($nrImages > 0):?>
			<?php $data = [ 'type' => 'hidden', 'id' => 'image' . $nrImages, 'name' => 'galleries_images['. $nrImages .'][image]', 'value' => set_value('galleries_images['. $nrImages .'][image]', $image->image ?? '' ) ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'id' => 'sorting_image'. $nrImages, 'name' => 'sorting_images[]', 'value' => $nrImages ?? '0' ];
			echo form_input($data);?>
			
			<?php $data = [ 'type' => 'hidden', 'name' => 'galleries_images['. $nrImages .'][id]', 'value' => set_value('galleries_images['. $nrImages .'][id]', $image->id ?? '' ) ];
			echo form_input($data);?>
		<?php endif;?>
	  </div>
	</div>
</div>