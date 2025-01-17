<section class="request page-details" id="request">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<?php if (session()->has('errors')): ?>
					<div class="content">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= \Config\Services::validation()->listErrors(); ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
					</div>
				<?php endif; ?>

				<?php if (!empty($errors)) : ?>
					<div class="content">
						<div class="alert alert-danger">
						<?php foreach ($errors as $field => $e) : ?>
							<p><?= $e ?></p>
						<?php endforeach ?>
						</div>
					</div>
				<?php endif ?>

				<?php if (session()->has('error')): ?>
					<div class="content">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= session('error') ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
					</div>
				<?php endif; ?>

				<?php if (session()->has('message')): ?>
					<div class="content">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= session('message') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="col-lg-4 col-bordered">
				<h3 class="text-center">
					<?php echo lang('AccountLang.passwordSetNewTitle'); ?>
				</h3>

				<div class="row">
					<!--Form-->
					<?= form_open($locale . '/users/password/new', 'method="post" class="needs-validation" id="registerForm"') ?>
            <?php echo form_hidden('token', $token); ?>

						<div class="row g-4">
              <div class="col-12">
                <label for="pass"><?= lang('AccountLang.newPassword') ?> *</label>

                <?php
                $data = [
                  'type' => 'password',
                  'id' => 'newPassword',
                  'name' => 'newPassword',
                  'autocomplete' => 'on',
                  'required' => true,
                  'class' => 'form-control home-form',
                  'placeholder' => lang('AccountLang.newPassword')
                ];

                echo form_input($data);
                ?>
              </div>

              <div class="col-12">
                <label for="pass"><?= lang('AccountLang.confirmPassword') ?> *</label>

                <?php
                $data = [
                  'type' => 'password',
                  'id' => 'confirmPassword',
                  'name' => 'confirmPassword',
                  'autocomplete' => 'on',
                  'required' => true,
                  'class' => 'form-control home-form',
                  'placeholder' => lang('AccountLang.confirmPassword')
                ];

                echo form_input($data);
                ?>
              </div>
						</div>

						<div class="text-center">
							<button class="btn btn-request btn-home-subbmit" type="submit">
								<?= lang('AccountLang.save') ?>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
