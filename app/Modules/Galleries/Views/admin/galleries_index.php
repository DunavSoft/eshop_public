  <!-- Content Wrapper. Contains galleries content -->
  <div class="content-wrapper">
  	<!-- Content Header (Gallery header) -->
  	<section class="content-header">
  		<div class="container-fluid">
  			<div class="row mb-2">
  				<div class="col-sm-6">
  					<h1><?= lang('GalleriesLang.pageTitle') ?><?= ($deleted == 1 ? lang('AdminPanel.whichDeleted') : '') ?></h1>
  				</div>
  				<div class="col-sm-6">
  					<div class="float-right btn-group">
  						<?php if ($deleted == 1) : ?>
  							<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/galleries'); ?>">
  								<i class="fas fa-list" data-tooltip="tooltip" title="<?= lang('GalleriesLang.backToList') ?>"></i>
  							</a>
  						<?php else : ?>
  							<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/galleries/index/1'); ?>">
  								<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('GalleriesLang.pageTitle') ?><?= lang('AdminPanel.whichDeleted') ?>"></i>
  							</a>
  						<?php endif; ?>
  						<a class="btn btn-primary btn-sm float-right" href="<?= site_url($locale . '/admin/galleries/form') ?>">
  							<i class="fas fa-plus"></i> <?= lang('GalleriesLang.add') ?>
  						</a>
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
  								<?= lang('AdminPanel.name') ?>
  							</th>
							<th class="text-nowrap text-center">
  								<?= lang('GalleriesLang.showHome') ?>
  							</th>
							  <th class="text-nowrap text-center">
  								<?= lang('GalleriesLang.showMenu') ?>
  							</th>
  							<th class="text-nowrap text-center">
  								<?= lang('GalleriesLang.code') ?>
  							</th>
  							<th style="width: 10%" class="text-nowrap text-center">
  								<?= lang('AdminPanel.status') ?>
  							</th>
  							<th class="project-actions text-right text-nowrap" style="width: 26%"><?= lang('AdminPanel.action') ?></th>
  						</tr>
  					</thead>
  					<tbody>
  						<?php if (count($elements) == 0) : ?>
  							<tr id="row0">
  								<td colspan="5" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
  							</tr>
  						<?php endif; ?>
  						<?php foreach ($elements as $element) : ?>
  							<tr>
  								<td>
  									<?= $element->id ?>
  								</td>
  								<td><?= $element->title ?></td>
								<td class="text-nowrap text-center">
									<?= ($element->show_home == 1) ? '<i class="fas fa-check"></i>' : ''; ?>
								</td>
								<td class="text-nowrap text-center">
									<?= ($element->show_list == 1) ? '<i class="fas fa-check"></i>' : ''; ?>
								</td>
  								<td class="text-nowrap text-center">{{gallery, <?= $element->id ?>}}</td>
  								<td class="project-state text-nowrap text-center">
  									<?php if ($element->active == 1) : ?>
  										<span class="badge badge-success"><?= lang('AdminPanel.active') ?></span>
  									<?php else : ?>
  										<span class="badge badge-danger"><?= lang('AdminPanel.inactive') ?></span>
  									<?php endif; ?>
  								</td>
  								<td class="project-actions text-right text-nowrap">
  									<?php if ($element->deleted_at == '') : ?>
  										<div class="btn-group float-right">
  											<a class="btn btn-primary btn-sm" href="<?= site_url($locale . '/admin/galleries/form/' . $element->id) ?>">
  												<i class="fas fa-pencil-alt" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>"></i>
  											</a>
  											<a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/galleries/form/' . $element->id . '/1') ?>">
  												<i class="fa fa-copy" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>"></i>
  											</a>
  											<a class="btn btn-danger btn-sm" id="button_id<?= $element->id; ?>" href="<?= site_url($locale . '/admin/galleries/delete/' . $element->id); ?>" data-toggle="modal" data-target="#ModalConfirm" onclick="areyousure(<?= $element->id; ?>);">
  												<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>"></i>
  											</a>
  										</div>
  									<?php else : ?>
  										<a class="btn btn-primary btn-sm" href="<?= site_url($locale . '/admin/galleries/restore/' . $element->id); ?>">
  											<i class="fas fa-undo-alt"></i> <?= lang('AdminPanel.restore') ?>
  										</a>
  									<?php endif; ?>
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