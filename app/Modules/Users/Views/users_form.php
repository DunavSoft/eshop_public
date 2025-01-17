<?= form_open($locale . '/admin/users/form_submit/' . $id, 'id="form" role="form" class="needs-validation"') ?>

<?= form_hidden('save[id]', $id ?? '') ?>

<!-- Main content -->
<div class="container-fluid p-0">
	<!-- /.card -->
	<div class="card card-primary card-outline rounded-0">
		<div class="card-body">
			<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="custom-content-below-content-tab" data-toggle="pill" href="#custom-content-below-content" role="tab" aria-controls="custom-content-below-content" aria-selected="true"><?= lang('AdminPanel.common') ?></a>
				</li>
				<?php if ($id != 'new') : ?>
					<li class="nav-item">
						<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info'); ?></a>
					</li>
				<?php endif; ?>
			</ul>
			<div class="tab-content" id="custom-content-below-tabContent">

				<div class="tab-pane fade show active" id="custom-content-below-content" role="tabpanel" aria-labelledby="custom-content-below-content-tab">
					<span class="form-horizontal">
						<div class="card-body">
							<div class="form-group row">
								<label for="firstname" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.firstName') ?> <span class="text-danger">*</span> </label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'firstname', 'name' => 'save[firstname]', 'value' => set_value('firstname', $firstname), 'class' => 'form-control', 'placeholder' => 'First name', 'required' => 'required'];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="lastname" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.lastName') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'lastname', 'name' => 'save[lastname]', 'value' => set_value('lastname', $lastname), 'class' => 'form-control', 'placeholder' => 'Last name'];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('AdminPanel.email') ?> <span class="text-danger">*</span> </label>
								<div class="col-sm-10">
									<?php
									if ($id != 'new' && $duplicate != 1) {
										$data = ['readonly' => 'readonly', 'id' => 'email', 'name' => 'save[email]', 'value' => set_value('email', $email), 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required'];
									} else {
										$data = ['id' => 'email', 'name' => 'save[email]', 'value' => set_value('email', $email), 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required'];
									}

									echo form_input($data);
									?>
								</div>
							</div>

							<div class="form-group row">
								<label for="phoneNumber" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.phoneNumber') ?></label>

								<div class="col-sm-10">
									<?php
									$data = [
										'id' => 'phoneNumber',
										'name' => 'save[phone_number]',
										'value' => set_value('phone_number', $phone_number),
										'class' => 'form-control',
										'placeholder' => 'Phone Number'
									];

									echo form_input($data);
									?>
								</div>
							</div>

							<div class="form-group row">
								<label for="city" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.city') ?></label>

								<div class="col-sm-10">
									<?php
									$data = [
										'id' => 'city',
										'name' => 'save[city]',
										'value' => set_value('city', $city),
										'class' => 'form-control'
									];

									echo form_input($data);
									?>
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.password') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'password', 'name' => 'save[password]', 'value' => '', 'class' => 'form-control'];
									echo form_password($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="confirm" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.repeatPassword') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'confirm', 'name' => 'save[confirm]', 'value' => '', 'class' => 'form-control'];
									echo form_password($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="start_turnover" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.start_turnover') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'start_turnover', 'name' => 'save[start_turnover]', 'value' => set_value('start_turnover', $start_turnover), 'class' => 'form-control', 'required' => 'required'];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="turnover" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.turnover') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'turnover', 'name' => 'save[turnover]', 'value' => set_value('turnover', $turnover), 'class' => 'form-control', 'readonly' => true];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="sum_turnover" class="col-sm-2 col-form-label text-left text-sm-right"><?= lang('UsersLang.sum_turnover') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'sum_turnover', 'name' => 'save[sum_turnover]', 'value' => set_value('sum_turnover', number_format(($start_turnover + $turnover), 2, '.', '')), 'class' => 'form-control', 'readonly' => true];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="percent_loyalclient" class="col-sm-2 col-form-label text-left text-sm-right "><?= lang('UsersLang.loyalclient') ?></label>
								<div class="col-sm-10">
									<?php
									$data = ['id' => 'percent_loyalclient', 'name' => 'save[percent_loyalclient]', 'value' => set_value('percent_loyalclient', lang('UsersLang.percent_loyalclient', [$percent_loyalclient])), 'class' => 'form-control', 'readonly' => true];
									echo form_input($data);
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="confirm" class="col-sm-2 col-form-label text-left text-sm-right">
									<?= lang('UsersLang.active') ?>
								</label>

								<div class="col-sm-10">
									<?php
									$options = [
										1 => lang('AdminPanel.yes'),
										0 => lang('AdminPanel.no'),
									];
									echo form_dropdown('save[active]', $options, set_value('save[active]', $active), 'class="form-control"');
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
								<label for="created_at" class="col-sm-2 text-left text-sm-right"><?= lang('AdminPanel.createdAt') ?></label>
								<div class="col-sm-10">
									<?php echo date('d.m.Y H:i', $created_at); ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="updated_at" class="col-sm-2 text-left text-sm-right"><?= lang('AdminPanel.updatedAt') ?></label>
								<div class="col-sm-10">
									<?php echo date('d.m.Y H:i', $updated_at); ?>
								</div>
							</div>
						</div>
					</span>
				</div>
			</div>
			<!-- /.tab-content -->

			<div class="row mt-0 mb-2">
				<div class="col-sm-12 text-center">
					<div class="btn-group">
						<input class="btn btn-primary submit-button" type="button" value="<?= lang('AdminPanel.save') ?>" />
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