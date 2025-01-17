  <?= view('App\Views\template\are_you_sure') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	<!-- Content Header (Page header) -->
  	<section class="content-header">
  		<div class="container-fluid">
  			<div class="row mb-2">
  				<div class="col-sm-6">
  					<h1><?= ($deleted != false) ? lang('AdminPanel.administrators') . lang('AdminPanel.whichDeleted') : lang('AdminPanel.administrators') ?></h1>
  				</div>
  				<div class="col-sm-6">
  					<div class="float-right btn-group">
  						<?php if ($deleted == false) : ?>
  							<a class="btn btn-secondary btn-sm" href="<?php echo site_url($locale . '/admin/administrators/deleted'); ?>">
  								<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPanel.administrators') ?><?= lang('AdminPanel.whichDeleted') ?>"></i>
  							</a>
  						<?php else : ?>
  							<a class="btn btn-secondary btn-sm" href="<?php echo site_url($locale . '/admin/administrators'); ?>">
  								<i class="fas fa-list" data-tooltip="tooltip" title="<?= lang('AdminPanel.backtoList') ?>"></i>
  							</a>
  						<?php endif; ?>
  						<a class="btn btn-primary btn-sm float-right" href="<?= site_url($locale . '/admin/administrators/form/new') ?>">
  							<i class="fas fa-plus"></i> <?= lang('AdminLang.add') ?>
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

  	<!-- Main content -->
  	<section class="content">

  		<!-- Default box -->
  		<div class="card card-primary card-outline">

  			<div class="card-body p-0 table-responsive">
  				<table class="table table-striped projects">
  					<thead>
  						<tr>
  							<th>
  								#
  							</th>
  							<th>
  								<?= lang('AdminPanel.email') ?>
  							</th>
  							<th style="width: 30%">
  								<?= lang('AdminPanel.name') ?>
  							</th>
  							<th class="text-nowrap text-center">
  								<?= lang('AdminPanel.language') ?>
  							</th>
  							<th class="text-nowrap text-center">
  								<?= lang('AdminPanel.access') ?>
  							</th>
  							<th class="project-actions text-right text-nowrap"><?= lang('AdminPanel.action') ?></th>
  						</tr>
  					</thead>
  					<tbody>
  						<?php if (count($elements) == 0) : ?>
  							<tr id="row0">
  								<td colspan="6" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
  							</tr>
  						<?php endif; ?>
  						<?php foreach ($elements as $element) : ?>
  							<tr>
  								<td>
  									<?= $element->id ?>
  								</td>
  								<td class="text-nowrap"><?= $element->email ?></td>
  								<td><?= $element->firstname ?> <?= $element->lastname ?></td>
  								<td class="text-center text-nowrap"><?= $element->language ?></td>
  								<td class="text-center text-nowrap"><?= $adminAccessOption[$element->access] ?></td>
  								<td class="project-actions text-right text-nowrap">
  									<div class="btn-group float-right">
  										<?php if ($deleted == false) : ?>
  											<a class="btn btn-primary btn-sm" href="<?= site_url($locale . '/admin/administrators/form/' . $element->id) ?>">
  												<i class="fas fa-pencil-alt" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>"></i>
  											</a>
  											<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/administrators/form/' . $element->id . '/1') ?>">
  												<i class="fa fa-copy" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>"></i>
  											</a>
  											<a class="btn btn-danger btn-sm" id="button_id<?php echo $element->id; ?>" href="<?php echo site_url($locale . '/admin/administrators/delete/' . $element->id); ?>" data-toggle="modal" data-target="#ModalConfirm" onclick="areyousure(<?php echo $element->id; ?>);">
  												<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>"></i>
  											</a>
  										<?php else : ?>
  											<a class="btn btn-primary btn-sm" href="<?php echo site_url($locale . '/admin/administrators/restore/' . $element->id); ?>">
  												<i class="fas fa-undo"></i> <?= lang('AdminPanel.restore') ?>
  											</a>
  										<?php endif; ?>
  									</div>
  								</td>
  							</tr>
  						<?php endforeach; ?>
  					</tbody>
  				</table>
  			</div>
  			<!-- /.card-body -->
  		</div>
  		<!-- /.card -->

  	</section>
  	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->