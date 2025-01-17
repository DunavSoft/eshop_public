  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	<div id="success" class="m-3 alert alert-success alert-dismissible fade show d-none" role="alert">
  		<span id="success-message"></span>
  		<button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
  			<span aria-hidden="true">&times;</span>
  		</button>
  	</div>

  	<div id="error" class="m-3 alert alert-danger fade show d-none" role="alert">
  		<span id="error-message"></span>
  	</div>

  	<!-- Content Header (Page header) -->
  	<section class="content-header pb-0">
  		<div class="container-fluid">
  			<div class="row mb-2">
  				<div class="col-sm-6 col-xs-12">
  					<h1><?= (($deleted != false) ? lang('UsersLang.users') . lang('AdminPanel.whichDeleted') : lang('UsersLang.users')) ?></h1>
  				</div>
  				<div class="col-sm-6 col-xs-12">
  					<div class="float-right btn-group">
  						<?php if ($deleted == false) : ?>
  							<a class="btn btn-secondary btn-sm" href="<?php echo site_url($locale . '/admin/users/1/deleted'); ?>">
  								<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('UsersLang.users') ?><?= lang('AdminPanel.whichDeleted') ?>"></i>
  							</a>
  						<?php else : ?>
  							<a class="btn btn-secondary btn-sm" href="<?php echo site_url($locale . '/admin/users/' . $page); ?>">
  								<i class="fas fa-list" data-tooltip="tooltip" title="<?= lang('UsersLang.back') ?>"></i>
  							</a>
  						<?php endif; ?>
  						<a class="btn btn-primary btn-sm float-right edit-button" href="<?= site_url($locale . '/admin/users/form') ?>" data-id="new" data-toggle="modal" data-target="#ModalFormSecondary">
  							<i class="fas fa-plus"></i> <?= lang('UsersLang.add') ?>
  						</a>
  					</div>
  				</div>
  			</div>
  		</div><!-- /.container-fluid -->
  	</section>

  	<?php if (session()->has('message')) : ?>
  		<div class="content">
  			<div class="alert alert-success alert-dismissible fade show" role="alert">
  				<?= session('message') ?>
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  			</div>
  		</div>
  	<?php endif; ?>

  	<?php if (session()->has('error')) : ?>
  		<div class="content">
  			<div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<?= session('error') ?>
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  			</div>
  		</div>
  	<?php endif ?>

  	<?php if (session()->has('warning')) : ?>
  		<div class="content">
  			<div class="alert alert-warning alert-dismissible fade show" role="alert">
  				<?= session('warning') ?>
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  			</div>
  		</div>
  	<?php endif ?>

  	<!-- Main content -->
  	<section class="content">
  		<!-- Default box -->
  		<div class="card card-primary card-outline">

  			<div class="card-body p-0" id="ajax-content">
  				<?php include('users_index_ajax.php') ?>
  			</div>
  			<!-- /.card-body -->
  		</div>
  		<!-- /.card -->
  	</section>
  	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->