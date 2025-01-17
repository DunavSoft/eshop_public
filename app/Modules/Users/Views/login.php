<section class="page-details request" id="request">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<?php if (session()->has('errors')): ?>
					<div class="content">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= \Config\Services::validation()->listErrors(); ?>
			<!--	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>  -->
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
						</div>
					</div>
				<?php endif; ?>

				<?php if (session()->has('message')): ?>
					<div class="content">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= session('message') ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="col-lg-4 col-bordered">
				<h1 class="text-center" style="font-family: 'Merriweather', 'sans-serif'; margin-bottom: 30px">
					<?php echo lang('AccountLang.login'); ?>
				</h1>

				<div class="row">
					<!--Form-->

					<form class="needs-validation" novalidate="" method="post" action="" id="main-form">
						<div class="row g-4">

							<div class="col-12">

								<div class="input-group mb-3">
									<span class="input-group-text home-form">
										<i class="fa fa-user" aria-hidden="true"></i>
									</span>
                  <?php
                  $data = [
                    'type' => 'email',
                    'id' => 'email',
                    'name' => 'email',
                    'required' => true,
										'value' => set_value('email', $email ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.email')
                  ];

                  echo form_input($data);
                  ?>
								</div>
							</div>
							<div class="col-12">
								<div class="input-group mb-3">
									<span class="input-group-text home-form">
										<i class="fa fa-lock" aria-hidden="true"></i>
									</span>
									<?php
                  $data = [
                    'type' => 'password',
                    'id' => 'password',
                    'name' => 'password',
                    'required' => true,
										'autocomplete' => 'on',
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.password')
                  ];

                  echo form_input($data);
                  ?>
								</div>
							</div>

						</div>
						<div class="text-center">
							<a href="<?php echo base_url('/users/password/reset') ?>" class="nav-link"><?= lang('AccountLang.forgottenPassword') ?></a>
							<a href="<?php echo base_url('/users/register') ?>" class="nav-link"><?= lang('AccountLang.registerLink') ?></a>
							
							<button class="btn btn-request btn-home-subbmit" type="submit">
								<?php echo lang('UsersLang.loginButtonLabel'); ?>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
