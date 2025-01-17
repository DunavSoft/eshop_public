<?= form_open_multipart($locale . '/admin/pages/form_submit/' . $id, 'id="form" role="form" class="needs-validation"') ?>
<!-- Main content -->
<div class="container-fluid p-0">
	<!-- /.card -->
	<div class="card card-primary card-outline rounded-0">
		<div class="card-body">
			<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
				<?php $i = 0;
				foreach ($languages as $language) : $i++; ?>
					<li class="nav-item">
						<a class="nav-link <?php if ($i == 1) : ?>active<?php endif; ?>" id="custom-content-below-content-tab<?= $language->id ?>" data-toggle="pill" href="#custom-content-below-content<?= $language->id ?>" role="tab" aria-controls="custom-content-below-content<?= $language->id ?>" <?php if ($i == 1) : ?>aria-selected="true" <?php endif; ?>><?= $language->native_name ?></a>
					</li>
				<?php endforeach; ?>

				<li class="nav-item">
					<a class="nav-link" id="custom-content-below-attributes-tab" data-toggle="pill" href="#custom-content-below-attributes" role="tab" aria-controls="custom-content-below-attributes" aria-selected="false"><?= lang('AdminPanel.attributes'); ?></a>
				</li>

				<li class="nav-item">
					<a class="nav-link" id="custom-content-below-image-tab" data-toggle="pill" href="#custom-content-below-image" role="tab" aria-controls="custom-content-below-image" aria-selected="false"><?= lang('AdminPanel.image'); ?></a>
				</li>

				<?php if ($id != 'new') : ?>
					<li class="nav-item">
						<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?= lang('AdminPanel.info'); ?></a>
					</li>
				<?php endif; ?>
			</ul>

			<div class="tab-content" id="custom-content-below-tabContent">
				<?php $i = 0;
				foreach ($languages as $language) : $i++; ?>
					<div class="tab-pane fade <?php if ($i == 1) : ?>show active<?php endif; ?>" id="custom-content-below-content<?= $language->id; ?>" role="tabpanel" aria-labelledby="custom-content-below-content-tab<?= $language->id; ?>">

						<?php
						if ($id != 'new') {
							echo form_hidden('pages_languages[' . $language->id . '][id]', $pagesLanguages[$language->id]->id ?? '');
						} else {
							echo form_hidden('pages_languages[' . $language->id . '][id]', '');
						}
						?>

						<span class="form-horizontal">
							<div class="card-body">
								<div class="form-group row">
									<label for="title<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPagesLang.Title'); ?> <span class="text-danger">*</span></label>
									<div class="col-sm-10">
										<?php
										$data = ['id' => 'title' . $language->id, 'name' => 'pages_languages[' . $language->id . '][title]', 'value' => set_value('pages_languages[' . $language->id . '][title]', $pagesLanguages[$language->id]->title ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPagesLang.Title'), 'required' => 'required'];
										echo form_input($data);
										?>
									</div>
								</div>
							</div>
						</span>

						<!-- content -->
						<hr />

						<?php
						$contentId = 'content_' . $language->id;
						$data = ['name' => 'pages_languages[' . $language->id . '][content]', 'id' => $contentId, 'class' => 'ckeditor'];
						echo form_textarea($data, set_value('pages_languages[' . $language->id . '][content]', $pagesLanguages[$language->id]->content ?? '', false));
						?>

						<hr />

						<span class="form-horizontal">
							<div class="card-body">
								<div class="form-group row">
									<label for="slug<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.slug'); ?></label>
									<div class="col-sm-10">
										<?php
										$data = ['id' => 'slug' . $language->id, 'name' => 'pages_languages[' . $language->id . '][slug]', 'value' => set_value('pages_languages[' . $language->id . '][slug]', $pagesLanguages[$language->id]->slug ?? ''), 'class' => 'form-control slug', 'placeholder' => lang('AdminPanel.slug')];
										echo form_input($data);
										?>

										<div class="warning-feedback" id="feedback_slug<?= $language->id ?>">
											<?= lang('AdminPanel.slugLenghtWarningQuestion'); ?>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label for="seo_title<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.seoTitle'); ?></label>
									<div class="col-sm-10">
										<?php
										$data = ['id' => 'seo_title' . $language->id, 'name' => 'pages_languages[' . $language->id . '][seo_title]', 'value' => set_value('pages_languages[' . $language->id . '][seo_title]', $pagesLanguages[$language->id]->seo_title ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.seoTitle')];
										echo form_input($data);
										?>
									</div>
								</div>

								<div class="form-group row">
									<label for="meta<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.seoMeta'); ?></label>
									<div class="col-sm-10">
										<?php
										$data = ['id' => 'meta' . $language->id, 'name' => 'pages_languages[' . $language->id . '][meta]', 'class' => 'form-control', 'placeholder' => lang('AdminPanel.seoMeta')];
										echo form_textarea($data, set_value('pages_languages[' . $language->id . '][meta]', $pagesLanguages[$language->id]->meta ?? ''));
										?>
									</div>
								</div>
							</div>
						</span>
					</div>
				<?php endforeach; ?>

				<div class="tab-pane fade" id="custom-content-below-attributes" role="tabpanel" aria-labelledby="custom-content-below-attributes-tab">
					<span class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label for="active" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.active'); ?></label>
								<div class="col-sm-10">
									<?php
									$options = [
										1 => lang('AdminPanel.yes'),
										0 => lang('AdminPanel.no'),
									];
									echo form_dropdown('pages[active]', $options, set_value('pages[active]', $active), 'class="form-control"');
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="sequence" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.sequence'); ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'sequence', 'name' => 'pages[sequence]', 'value' => set_value('pages[sequence]', $sequence ?? '1'), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.sequence')];
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
								<label for="created_at" class="col-sm-2 text-start text-sm-right"><?= lang('AdminPanel.createdAt'); ?></label>
								<div class="col-sm-10">
									<?= date('d.m.Y H:i', $created_at); ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="updated_at" class="col-sm-2 text-start text-sm-right"><?= lang('AdminPanel.updatedAt'); ?></label>
								<div class="col-sm-10">
									<?= date('d.m.Y H:i', $updated_at); ?>
								</div>
							</div>
						</div>
					</span>
				</div>

				<div class="tab-pane fade" id="custom-content-below-image" role="tabpanel" aria-labelledby="custom-content-below-image-tab">
					<span class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label for="inp" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.image'); ?></label>
								<div class="col-sm-10">
									<?= form_upload(['id' => 'inp', 'name' => 'upl', 'class' => 'form-control', 'accept' => '.jpg,.jpeg,.png']); ?>
									<small class="form-text text-muted"> <?= lang('AdminPanel.smallImageMessage'); ?> </small>
								</div>
							</div>
							<div class="form-group row">
								<label for="image" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.currentImage'); ?></label>
								<div class="col-sm-10">
									<img id="img" height="150" <?php if ($image != '') : ?>src="<?= $image; ?>" <?php endif; ?>>

									<a class="btn btn-danger btn-sm" href="javascript:" id="removeImageButton" onclick="removeImage();" <?php if ($image == '') : ?>style="display:none" <?php endif; ?>>
										<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPanel.deleteImage') ?>"></i>
									</a>

									<?php $data = ['type' => 'hidden', 'id' => 'image', 'name' => 'pages[image]', 'value' => set_value('pages[image]', (string)$image)];
									echo form_input($data); ?>
								</div>
							</div>

							<?php $i = 0;
							foreach ($languages as $language) : $i++; ?>
								<div class="form-group row">
									<label for="img_alt<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.imgAlt'); ?> <?= $language->native_name ?></label>
									<div class="col-sm-4">
										<?php
										$data = ['id' => 'img_alt' . $language->id, 'name' => 'pages_languages[' . $language->id . '][img_alt]', 'value' => set_value('img_alt', $pagesLanguages[$language->id]->img_alt ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.imgAlt')];
										echo form_input($data);
										?>
									</div>

									<label for="img_title<?= $language->id; ?>" class="col-sm-2 col-form-label text-start text-sm-right"><?= lang('AdminPanel.imgTitle'); ?> <?= $language->native_name ?></label>
									<div class="col-sm-4">
										<?php
										$data = ['id' => 'img_title' . $language->id, 'name' => 'pages_languages[' . $language->id . '][img_title]', 'value' => set_value('img_title', $pagesLanguages[$language->id]->img_title ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.imgTitle')];
										echo form_input($data);
										?>
									</div>
								</div>
							<?php endforeach; ?> <br>

							<div class="form-group row">
								<label for="resp-inp" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.secondImage'); ?></label>
								<div class="col-sm-10">
									<?= form_upload(['id' => 'resp-inp', 'name' => 'upl-resp', 'class' => 'form-control', 'accept' => '.jpg,.jpeg,.png']); ?>
									<small class="form-text text-muted"> <?= lang('AdminPanel.smallImageMessage'); ?> </small>
								</div>
							</div>
							<div class="form-group row">
								<label for="resp-image" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.currentSecondImage'); ?></label>
								<div class="col-sm-10">
									<img id="resp-img" height="150" <?php if ($image_responsive != '') : ?>src="<?= $image_responsive; ?>" <?php endif; ?>>

									<a class="btn btn-danger btn-sm" href="javascript:" id="removeRespImageButton" onclick="removeRespImage();" <?php if ($image_responsive == '') : ?>style="display:none" <?php endif; ?>>
										<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPanel.deleteImage') ?>"></i>
									</a>

									<?php $data = ['type' => 'hidden', 'id' => 'resp-image', 'name' => 'pages[image_responsive]', 'value' => set_value('pages[image_responsive]', (string)$image_responsive)];
									echo form_input($data); ?>
								</div>
							</div>

							<?php $i = 0;
							foreach ($languages as $language) : $i++; ?>
								<div class="form-group row">
									<label for="resp_img_alt<?= $language->id; ?>" class="col-sm-2 col-form-label text-sm-right"><?= lang('AdminPanel.respImgAlt'); ?> <?= $language->native_name ?></label>
									<div class="col-sm-4">
										<?php
										$data = ['id' => 'resp_img_alt' . $language->id, 'name' => 'pages_languages[' . $language->id . '][resp_img_alt]', 'value' => set_value('resp_img_alt', $pagesLanguages[$language->id]->resp_img_alt ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.respImgAlt')];
										echo form_input($data);
										?>
									</div>

									<label for="resp_img_title<?= $language->id; ?>" class="col-sm-2 col-form-label text-start text-sm-right"><?= lang('AdminPanel.respImgTitle'); ?> <?= $language->native_name ?></label>
									<div class="col-sm-4">
										<?php
										$data = ['id' => 'resp_img_title' . $language->id, 'name' => 'pages_languages[' . $language->id . '][resp_img_title]', 'value' => set_value('resp_img_title', $pagesLanguages[$language->id]->resp_img_title ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.respImgTitle')];
										echo form_input($data);
										?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</span>
				</div>

				<div class="row mt-0 mb-2">
					<div class="col-sm-12 text-center">
						<div class="btn-group">
							<input class="btn btn-primary submit-button" type="button" value="<?= lang('AdminPanel.save') ?>" />
							<button class="btn btn-light" type="button" data-tooltip="tooltip" title="<?= lang('AdminPanel.close') ?>" data-dismiss="modal">&times;</button>
						</div>
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
	try {
		if (is_array($form_js)) {
			foreach ($form_js as $js) {
				echo view($js);
			}
		} else {
			echo view($form_js);
		}
	} catch (Exception $e) {
		echo "<pre><code>$e</code></pre>";
	}
}
?>

<script>
	$(document).ready(function() {
		$('[data-tooltip="tooltip"]').tooltip();

		$('#ModalFormSecondary').on('shown.bs.modal', function() {
			$(document).off('focusin.modal');
		});

		if ($('#ModalFormSecondary').hasClass('show')) {
			$(document).off('focusin.modal');
		}
	});

	function readFile() {
		if (this.files && this.files[0]) {
			var FR = new FileReader();

			FR.addEventListener("load", function(e) {
				document.getElementById("img").src = e.target.result;
				document.getElementById("image").value = e.target.result;
				document.getElementById("removeImageButton").style.display = 'inline-block';
			});

			FR.readAsDataURL(this.files[0]);
		}
	}

	function readRespFile() {
		if (this.files && this.files[0]) {
			var FRResp = new FileReader();

			FRResp.addEventListener("load", function(e) {
				document.getElementById("resp-img").src = e.target.result;
				document.getElementById("resp-image").value = e.target.result;
				document.getElementById("removeRespImageButton").style.display = 'inline-block';
			});

			FRResp.readAsDataURL(this.files[0]);
		}
	}

	var inpElement = document.getElementById("inp");
	var respInpElement = document.getElementById("resp-inp");

	if (inpElement) {
		inpElement.addEventListener('change', function() {
			var fileInput = this;
			var filePath = fileInput.value;
			var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
			if (!allowedExtensions.exec(filePath)) {
				alert('<?= lang('AdminPanel.imageError'); ?>');
				fileInput.value = '';
				return false;
			}
		});

		inpElement.addEventListener("change", readFile);
	}

	if (respInpElement) {
		respInpElement.addEventListener('change', function() {
			var fileInput = this;
			var filePath = fileInput.value;
			var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
			if (!allowedExtensions.exec(filePath)) {
				alert('<?= lang('AdminPanel.imageError'); ?>');
				fileInput.value = '';
				return false;
			}
		});

		respInpElement.addEventListener("change", readRespFile);
	}

	function removeImage() {
		if (confirm('<?= lang('AdminPanel.deleteImageMessage') ?>')) {
			document.getElementById("img").src = '';
			document.getElementById("image").value = '';
			document.getElementById("removeImageButton").style.display = 'none';
		}
	}

	function removeRespImage() {
		if (confirm('<?= lang('AdminPanel.deleteImageMessage') ?>')) {
			document.getElementById("resp-img").src = '';
			document.getElementById("resp-image").value = '';
			document.getElementById("removeRespImageButton").style.display = 'none';
		}
	}

	var uriLenght = <?= strlen(site_url()); ?>

	function checkSlugLenght(value, id) {
		if (value == '') {
			$('#feedback_' + id).hide();
			return;
		}

		if (value.length + uriLenght > <?= $uriWarningLength; ?>) {
			$('#feedback_' + id).show();
			$('#' + id).addClass('is-warning');
		} else {
			$('#feedback_' + id).hide();
			$('#' + id).removeClass('is-warning');
		}
	}

	$('.slug').keyup(function(e) {
		checkSlugLenght(this.value, this.id);
	});

	$(document).ready(function() {
		$('.slug').each(function() {
			checkSlugLenght(this.value, this.id);
		});
	});

	// Declare oldValuesArray once globally
	if (typeof oldValuesArray === 'undefined') {
		window.oldValuesArray = {};
	}

	//check for change slug if page exists
	<?php if ($id != 'new') : ?>
		$('.slug').each(function() {
			oldValuesArray[this.id] = this.value;
		});

		var changedSlugId = '';
		$('.slug').change(function() {
			changedSlugId = this.id;
			$('#ModalConfirmSlug').modal('show');
		});
	<?php endif; ?>
</script>