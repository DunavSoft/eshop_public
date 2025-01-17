<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('admin_panel/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url('admin_panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('admin_panel/dist/css/adminlte.min.css')?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
	 <?php /*<img src="<?=base_url('admin_panel/dist/img/admin_panel_logo_s.png')?>" height="48">*/?>
    <div class="card-header text-primary">
	  <div class="row">
		<span class="col-2"><img class="text-left" src="<?=base_url('admin_panel/dist/img/admin_panel_logo_s.png')?>" height="32"></span>
		<span class="col-8 text-center"><h5><?=lang('AdminPanel.adminPanel')?></h5><span>
	  </div>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?=lang('LoginLang.pleaseLogin')?></p>
	  
	  <?php if (session()->has('errors')): ?>
		<div class="content">
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					 <?= \Config\Services::validation()->listErrors(); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
	  <?php endif; ?>
	
		<?php if (! empty($errors)) : ?>
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
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
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

	  <?= form_open($locale . '/admin/login', 'id="form"') ?>
        <div class="input-group mb-3">
		  <?php
			$data = [ 'type' => 'input', 'id' => 'email', 'name' => 'email', 'value' => '', 'class' => 'form-control', 'placeholder' => lang('LoginLang.username') ];
			echo form_input($data);
		  ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
		  <?php
			$data = [ 'type' => 'password', 'id' => 'password', 'name' => 'password', 'value' => '', 'class' => 'form-control', 'placeholder' => lang('LoginLang.password') ];
			echo form_input($data);
		  ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                <?=lang('LoginLang.remember')?>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block"><?=lang('LoginLang.login')?></button>
          </div>
          <!-- /.col -->
        </div>
      <?= form_close() ?>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url('admin_panel/plugins/jquery/jquery.min.js')?>"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('admin_panel/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('admin_panel/dist/js/adminlte.min.js')?>"></script>
</body>
</html>
