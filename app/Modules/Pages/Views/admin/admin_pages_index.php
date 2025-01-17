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
  					<h1><?= lang('AdminPagesLang.pages') ?><?= ($deleted == 1 ? lang('AdminPanel.whichDeleted') : '') ?></h1>
  				</div>
  				<div class="col-sm-6 col-xs-12">
  					<div class="float-right btn-group">
  						<?php if ($deleted == 1) : ?>
  							<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/pages/' . $page); ?>">
  								<i class="fas fa-list" data-tooltip="tooltip" title="<?= lang('AdminPagesLang.backToPages') ?>"></i>
  							</a>
  						<?php else : ?>
  							<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/pages/deleted/' . $page); ?>">
  								<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPagesLang.pages') ?><?= lang('AdminPanel.whichDeleted') ?>"></i>
  							</a>
  							<a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/pages/form') ?>" data-id="new" data-toggle="modal" data-target="#ModalFormSecondary">
  								<i class="fas fa-plus"></i> <?= lang('AdminPagesLang.add') ?>
  							</a>
  						<?php endif; ?>
  					</div>
  				</div>
  			</div>
  		</div><!-- /.container-fluid -->
  	</section>

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

  	<?php if (!empty($error)) : ?>
  		<div class="content">
  			<div class="alert alert-danger alert-dismissible fade show" role="alert">
  				<?= $error; ?>
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  			</div>
  		</div>
  	<?php endif ?>

  	<?php if (!empty($warning)) : ?>
  		<div class="content">
  			<div class="alert alert-warning alert-dismissible fade show" role="alert">
  				<?= $warning; ?>
  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					<span aria-hidden="true">&times;</span>
  				</button>
  			</div>
  		</div>
  	<?php endif; ?>

  	<!-- Main content -->
  	<section class="content">

  		<!-- Default box -->
  		<div class="card card-primary card-outline">

  			<div class="card-body p-0" id="ajax-content">
  				<?php
					if (isset($ajax_view)) {
						try {
							if (is_array($ajax_view)) {
								foreach ($ajax_view as $v) {
									echo view($v);
								}
							} else {
								echo view($ajax_view);
							}
						} catch (Exception $e) {
							echo "<pre><code>$e</code></pre>";
						}
					}
					?>
  			</div>
  			<!-- /.card-body -->
  		</div>
  		<!-- /.card -->
  	</section>
  	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->