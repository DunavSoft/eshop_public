<style>
	.handle:hover {
		cursor: grab;
	}
</style>

<?= form_open($locale . '/admin/galleries/form/' . $id, 'id="form"') ?>
<!-- Content Wrapper. Contains galleries content -->
<div class="content-wrapper">
	<!-- Content Header (galleries header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>
						<a href="<?= site_url($locale . '/admin/galleries') ?>" data-tooltip="tooltip" title="<?= lang('GalleriesLang.backToList'); ?>"><i class="fa fa-arrow-left"></i></a> <?= $pageTitle ?>
					</h1>
				</div>
				<div class="col-sm-6">
					<div class="btn-group float-right">
						<input class="btn btn-primary" name="submit" type="submit" value="<?= lang('AdminPanel.save'); ?>" />
						<input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?= lang('AdminPanel.saveReturn'); ?>" />
					</div>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<?php if (!empty($errors)) : ?>
		<div class="content">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php foreach ($errors as $field => $e) : ?>
					<p><?= $e ?></p>
				<?php endforeach ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif ?>

	<?php if (!empty($message)) : ?>
		<div class="content">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?= $message; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!empty($warning)) : ?>
		<div class="content">
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<?= $warning; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif ?>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- /.card -->
			<div class="card card-primary card-outline">
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
							<a class="nav-link" id="custom-content-below-image-tab" data-toggle="pill" href="#custom-content-below-image" role="tab" aria-controls="custom-content-below-image" aria-selected="false"><?= lang('AdminPanel.images'); ?></a>
						</li>

						<?php if ($id != 'new' && $created_at > 0) : ?>
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
									echo form_hidden('galleries_languages[' . $language->id . '][id]', $galleriesLanguages[$language->id]->id ?? '');
								} else {
									echo form_hidden('galleries_languages[' . $language->id . '][id]', '');
								}
								?>
								<span class="form-horizontal">
									<div class="card-body">
										<div class="form-group row">
											<label for="title<?= $language->id ?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.title'); ?> <span class="text-danger">*</span></label>
											<div class="col-sm-10">
												<?php
												$data = ['id' => 'title' . $language->id, 'name' => 'galleries_languages[' . $language->id . '][title]', 'value' => set_value('galleries_languages[' . $language->id . '][title]', $galleriesLanguages[$language->id]->title ?? '', false), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.title')];
												echo form_input($data);
												?>
											</div>
										</div>

										<div class="form-group row">
											<label for="content<?= $language->id ?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.content'); ?></label>
											<div class="col-sm-10">
												<?php
												$data = [
													'id' => 'content' . $language->id,
													'name' => 'galleries_languages[' . $language->id . '][content]',
													'class' => 'ckeditor'
												];

												echo form_textarea($data, set_value('galleries_languages[' . $language->id . '][content]', $galleriesLanguages[$language->id]->content ?? ''));
												?>
											</div>
										</div>

										<div class="form-group row">
											<label for="slug<?= $language->id; ?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.slug'); ?></label>
											<div class="col-sm-10">
												<?php
												$data = ['id' => 'slug' . $language->id, 'name' => 'galleries_languages[' . $language->id . '][slug]', 'value' => set_value('galleries_languages[' . $language->id . '][slug]', $galleriesLanguages[$language->id]->slug ?? ''), 'class' => 'form-control slug', 'placeholder' => lang('AdminPanel.slug')];
												echo form_input($data);
												?>

												<div class="warning-feedback" id="feedback_slug<?= $language->id ?>">
													<?= lang('AdminPanel.slugLenghtWarningQuestion'); ?>
												</div>

											</div>
										</div>

										<div class="form-group row">
											<label for="seo_title<?= $language->id; ?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.seoTitle'); ?></label>
											<div class="col-sm-10">
												<?php
												$data = ['id' => 'seo_title' . $language->id, 'name' => 'galleries_languages[' . $language->id . '][seo_title]', 'value' => set_value('galleries__languages[' . $language->id . '][seo_title]', $galleriesLanguages[$language->id]->seo_title ?? ''), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.seoTitle')];
												echo form_input($data);
												?>
											</div>
										</div>

										<div class="form-group row">
											<label for="meta<?= $language->id; ?>" class="col-sm-2 col-form-label"><?= lang('AdminPanel.seoMeta'); ?></label>
											<div class="col-sm-10">
												<?php
												$data = ['id' => 'meta' . $language->id, 'name' => 'galleries_languages[' . $language->id . '][meta]', 'class' => 'form-control', 'placeholder' => lang('AdminPanel.seoMeta')];
												echo form_textarea($data, set_value('galleries_languages[' . $language->id . '][meta]', $galleriesLanguages[$language->id]->meta ?? ''));
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
										<label for="active" class="col-sm-2 col-form-label"><?= lang('AdminPanel.active'); ?></label>
										<div class="col-sm-10">
											<?php
											$options = [
												1 => lang('AdminPanel.yes'),
												0 => lang('AdminPanel.no'),
											];
											echo form_dropdown('save[active]', $options, set_value('save[active]', $active ?? '1'), 'class="form-control"');
											?>
										</div>
									</div>

									<div class="form-group row">
										<label for="sequence" class="col-sm-2 col-form-label"><?= lang('AdminPanel.sequence'); ?></label>
										<div class="col-sm-10">
											<?php
											$data = ['id' => 'sequence', 'name' => 'save[sequence]', 'value' => set_value('save[sequence]', $sequence ?? '1'), 'class' => 'form-control', 'placeholder' => lang('AdminPanel.sequence')];
											echo form_input($data);
											?>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-2"></div>
										<div class="col-sm-10">
											<?= form_checkbox('save[show_home]', 1, $show_home ?? false, 'class="form-control3" id="show_home"') ?>
											<label for="show_home"
                                                   class="pl-1 col-form-label"><?= lang('GalleriesLang.show_home') ?></label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-2"></div>
										<div class="col-sm-10">
											<?= form_checkbox('save[show_list]', 1, $show_list ?? false, 'class="form-control3" id="show_list"') ?>
											<label for="show_list"
                                                   class="pl-1 col-form-label"><?= lang('GalleriesLang.show_list') ?></label>
										</div>
									</div>

									<div class="form-group row">
										<label for="gallery_tag_open" class="col-sm-2 col-form-label"><?= lang('GalleriesLang.gallery_tag_open'); ?></label>
										<div class="col-sm-6">
											<?php
											$data = ['id' => 'gallery_tag_open', 'name' => 'save[gallery_tag_open]', 'value' => set_value('save[gallery_tag_open]', $gallery_tag_open ?? '', false), 'class' => 'form-control'];
											echo form_input($data);
											?>
										</div>

										<label for="gallery_tag_close" class="col-sm-3 col-form-label text-start text-sm-right"><?= lang('GalleriesLang.gallery_tag_close'); ?></label>
										<div class="col-sm-1">
											<?php
											$data = ['id' => 'gallery_tag_close', 'name' => 'save[gallery_tag_close]', 'value' => set_value('save[gallery_tag_close]', $gallery_tag_close ?? '', false), 'class' => 'form-control'];
											echo form_input($data);
											?>
										</div>
									</div>

									<div class="form-group row">
										<label for="gallery_element_tag_open" class="col-sm-2 col-form-label"><?= lang('GalleriesLang.gallery_element_tag_open'); ?></label>
										<div class="col-sm-6">
											<?php
											$data = ['id' => 'gallery_element_tag_open', 'name' => 'save[gallery_element_tag_open]', 'value' => set_value('save[gallery_element_tag_open]', $gallery_element_tag_open ?? '', false), 'class' => 'form-control'];
											echo form_input($data);
											?>
										</div>

										<label for="gallery_element_tag_close" class="col-sm-3 col-form-label text-start text-sm-right"><?= lang('GalleriesLang.gallery_element_tag_close'); ?></label>
										<div class="col-sm-1">
											<?php
											$data = ['id' => 'gallery_element_tag_close', 'name' => 'save[gallery_element_tag_close]', 'value' => set_value('save[gallery_element_tag_close]', $gallery_element_tag_close ?? '', false), 'class' => 'form-control'];
											echo form_input($data);
											?>
										</div>
									</div>

									<div class="form-group row">
										<label for="gallery_a_class" class="col-sm-2 col-form-label"><?= lang('GalleriesLang.gallery_a_class'); ?></label>
										<div class="col-sm-10">
											<?php
											$data = ['id' => 'gallery_a_class', 'name' => 'save[gallery_a_class]', 'value' => set_value('save[gallery_a_class]', $gallery_a_class ?? '', false), 'class' => 'form-control'];
											echo form_input($data);
											?>
										</div>
									</div>

									<div class="form-group row">
										<label for="gallery_image_class" class="col-sm-2 col-form-label"><?= lang('GalleriesLang.gallery_image_class'); ?></label>
										<div class="col-sm-10">
											<?php
											$data = ['id' => 'gallery_image_class', 'name' => 'save[gallery_image_class]', 'value' => set_value('save[gallery_image_class]', $gallery_image_class ?? '', false), 'class' => 'form-control'];
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
										<label for="created_at" class="col-sm-2 text-start text-sm-right"><?= lang('AdminPanel.createdAt') ?></label>
										<div class="col-sm-10">
											<?php if ($created_at > 0) echo date('d.m.Y H:i', $created_at); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="updated_at" class="col-sm-2 text-start text-sm-right"><?= lang('AdminPanel.updatedAt') ?></label>
										<div class="col-sm-10">
											<?php if ($updated_at > 0) echo date('d.m.Y H:i', $updated_at); ?>
										</div>
									</div>
								</div>
							</span>
						</div>

						<div class="tab-pane fade" id="custom-content-below-image" role="tabpanel" aria-labelledby="custom-content-below-image-tab">
							<span class="form-horizontal">
								<?php

								$passArray['nrImages'] = 0;
								$passArray['image'] = [];

								echo view('\App\Modules\Galleries\Views\admin\images', $passArray);

								?>
							</span>

							<a class="btn btn-danger btn-sm" href="javascript:" id="remove-all-images-button">
								<?= lang('GalleriesLang.image_delete_all') ?> <i class="fas fa-trash"></i>
							</a>

							<p class="pt-0 pb-0 mb-0 mt-0"><small id="ordering_help"><?= lang('GalleriesLang.ordering_help') ?></small></p>

							<span class="form-horizontal" id="images_sortable">
								<span id="image_card_sortable"></span>

								<?php foreach ($galleries_images as $image) {
									$passArray['nrImages']++;
									$passArray['image'] = $image;
									echo view('\App\Modules\Galleries\Views\admin\images', $passArray);
								} ?>
							</span>
						</div>

						<div class="row mt-0 mb-2">
							<div class="col-sm-12 text-center">
								<div class="btn-group">
									<input class="btn btn-primary" name="submit" type="submit" value="<?= lang('AdminPanel.save') ?>" />
									<input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?= lang('AdminPanel.saveReturn') ?>" />
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
	</section>
</div>
<!-- /.content-wrapper -->

<?= form_close() ?>