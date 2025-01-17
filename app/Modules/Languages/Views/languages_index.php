<?= form_open($locale . '/admin/languages', 'id="form"') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">
					<h1><?= lang('LanguagesLang.pageTitle') ?></h1>
				</div>
				<div class="col-sm-6">
					<div class="btn-group float-right">
						<input class="btn btn-primary" name="submit" type="submit" value="<?= lang('AdminPanel.saveReturn') ?>" />
					</div>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<?= \Config\Services::validation()->listErrors() ?>

	<?php if (!empty($errors)) : ?>
		<div class="content">
			<div class="alert alert-danger">
				<?php foreach ($errors as $field => $e) : ?>
					<p><?= $e ?></p>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>

	<?php if (!empty($message)) : ?>
		<div class="content">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?= $message ?>
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
						<li class="nav-item">
							<a class="nav-link active" id="custom-content-below-site-tab" data-toggle="pill" href="#custom-content-below-site" role="tab" aria-controls="custom-content-below-site" aria-selected="true"><?= lang('LanguagesLang.site') ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-admin-panel-tab" data-toggle="pill" href="#custom-content-below-admin-panel" role="tab" aria-controls="custom-content-below-admin-panel" aria-selected="false"><?= lang('AdminPanel.adminPanel') ?></a>
						</li>

						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-attributes-tab" data-toggle="pill" href="#custom-content-below-attributes" role="tab" aria-controls="custom-content-below-attributes" aria-selected="false"><?= lang('AdminPanel.content') ?></a>
						</li>

					</ul>

					<div class="tab-content" id="custom-content-below-tabContent">
						<div class="tab-pane fade show active table-responsive" id="custom-content-below-site" role="tabpanel" aria-labelledby="custom-content-below-site-tab">
							<table class="table table-striped projects">
								<thead>
									<tr>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.identificator') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.standartCode') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.uri') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.nativeName') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.englishName') ?>
										</th>
										<th class="text-nowrap text-center">
											<?php /* <?= lang('LanguagesLang.icon') ?> */ ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.active') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.hidden') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.main') ?>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($elements_site as $element) : ?>
										<tr>
											<td class="text-nowrap text-center"><?= $element->name ?></td>
											<td class="text-nowrap text-center"><?= $element->code ?></td>
											<td class="text-nowrap text-center"><?= $element->uri ?></td>
											<td class="text-nowrap text-center"><?= $element->native_name ?></td>
											<td class="text-nowrap text-center"><?= $element->english_name ?></td>
											<td class="text-nowrap text-center"><?php //echo $element->icon;
																				?></td>
											<td class="text-nowrap text-center">
												<?= form_checkbox('site_active[]', $element->id, (bool)$element->active) ?>
											</td>
											<td class="text-nowrap text-center">
												<?= form_checkbox('site_hidden[]', $element->id, (bool)$element->hidden) ?>
											</td>
											<td class="text-nowrap text-center">
												<?= form_radio('site_is_default', $element->id, (bool)$element->is_default) ?>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>

						<div class="tab-pane fade table-responsive" id="custom-content-below-admin-panel" role="tabpanel" aria-labelledby="custom-content-below-admin-panel-tab">

							<table class="table table-striped projects">
								<thead>
									<tr>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.identificator') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.standartCode') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.uri') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.nativeName') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.englishName') ?>
										</th>
										<th class="text-nowrap text-center">
											<?php /* <?= lang('LanguagesLang.icon') ?> */ ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.active') ?>
										</th>
										<th class="text-nowrap text-center">
											<?= lang('LanguagesLang.main') ?>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($elements_admin as $element) : ?>
										<tr>
											<td class="text-nowrap text-center"><?= $element->name ?></td>
											<td class="text-nowrap text-center"><?= $element->code ?></td>
											<td class="text-nowrap text-center"><?= $element->uri ?></td>
											<td class="text-nowrap text-center"><?= $element->native_name ?></td>
											<td class="text-nowrap text-center"><?= $element->english_name ?></td>
											<td class="text-nowrap text-center"><?php //echo $element->icon 
																				?></td>
											<td class="text-nowrap text-center">
												<?= form_checkbox('admin_active[]', $element->id, (bool)$element->active) ?>
											</td>
											<td class="text-nowrap text-center">
												<?= form_radio('admin_is_default', $element->id, (bool)$element->is_default) ?>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>

						<div class="tab-pane fade" id="custom-content-below-content" role="tabpanel" aria-labelledby="custom-content-below-content-tab">
							<span class="form-horizontal">
								<div class="card-body">
									<div class="form-group row">
										<label for="title" class="col-sm-2 col-form-label"><?= lang('AdminPanel.title') ?> <span class="text-danger">*</span></label>
										<div class="col-sm-10">
											<?php
											$data = ['id' => 'title', 'name' => 'save[title]', 'value' => set_value('title', ''), 'class' => 'form-control', 'placeholder' => 'Title'];
											echo form_input($data);
											?>
										</div>
									</div>
								</div>
							</span>
						</div>

						<div class="tab-pane fade" id="custom-content-below-attributes" role="tabpanel" aria-labelledby="custom-content-below-attributes-tab">
							<span class="form-horizontal">
								<div class="card-body">
									<?php foreach ($languagesFront as $element) : ?>

										<div class="form-group row">
											<label for="lang_variable" class="col-sm-2 col-form-label"><?= lang('LanguagesLang.variable') ?> <span class="text-danger">*</span></label>
											<div class="col-sm-4">
												<?php
												$data = ['id' => 'lang_variable', 'name' => "languages_front[$element->id][lang_variable]", 'value' => set_value("languages_front[$element->id][lang_variable]", $element->lang_variable), 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Variable', 'readonly' => 'readonly'];
												echo form_input($data);
												?>
											</div>
										</div>
										<div class="form-group row">
											<label for="content" class="col-sm-2 col-form-label"><?= lang('LanguagesLang.content') ?></label>
											<div class="col-sm-10">
												<?php
												$data = ['id' => 'content', 'name' => "languages_front[$element->id][content]", 'value' => $element->content, 'class' => 'form-control', 'placeholder' => 'Content'];
												echo form_textarea($data);
												?>
											</div>
										</div>
									<?php endforeach ?>

									<div class="form-group row">
										<label for="content" class="col-sm-2 col-form-label"><?= lang('LanguagesLang.help_text') ?></label>
										<div class="col-sm-10">
											<?= nl2br(lang('LanguagesLang.help')) ?>
										</div>
									</div>

								</div>

							</span>

						</div>

					</div> <!-- /.tab-content -->

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