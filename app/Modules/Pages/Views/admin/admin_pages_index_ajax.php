<table class="table table-responsive table-striped table-hover">
	<thead>
		<tr>
			<th class="text-nowrap" style="width: 1%">
				#
			</th>
			<th>
				<?= lang('AdminPanel.name') ?>
			</th>
			<th class="text-nowrap text-center">
				<?= lang('AdminPanel.status') ?>
			</th>
			<th class="project-actions text-right" style="width: 26%"><?= lang('AdminPanel.action') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($pages) == 0) : ?>
			<tr id="row0">
				<td colspan="4" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
			</tr>
		<?php endif; ?>
		<?php foreach ($pages as $page) : ?>
			<tr id="row<?= $page->id ?>">
				<td <?= (isset($lastEdidtedId) && $lastEdidtedId == $page->id) ? 'class="bg-primary"' : '' ?>>
					<?= $page->id; ?>
				</td>
				<td><?= $page->title; ?></td>
				<td class="project-state text-center">
					<?php if ($page->active == 1) : ?>
						<span class="badge badge-success"><?= lang('AdminPanel.active') ?></span>
					<?php else : ?>
						<span class="badge badge-danger"><?= lang('AdminPanel.inactive') ?></span>
					<?php endif; ?>
				</td>
				<td class="project-actions text-right text-nowrap">
					<?php if ($page->deleted_at == '') : ?>
						<div class="btn-group float-right">
							<a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/pages/form/' . $page->id); ?>" data-id="pages<?= $page->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/pages') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>">
								<i class="fas fa-pencil-alt"></i>
							</a>
							<a class="btn btn-secondary btn-sm edit-button" href="<?= site_url($locale . '/admin/pages/form/' . $page->id . '/1'); ?>" data-id="pagescopy<?= $page->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/pages') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>">
								<i class="fa fa-copy"></i>
							</a>
							<a class="btn btn-danger btn-sm delete-button" href="<?= site_url($locale . '/admin/pages/delete/' . $page->id); ?>" data-toggle="modal" data-target="#ModalConfirmAjax" data-ajax-url="<?= site_url($locale . '/admin/pages') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>">
								<i class="fas fa-trash"></i>
							</a>
						</div>
					<?php else : ?>
						<span class="text-nowrap">
							<a class="btn btn-primary btn-sm process-button" href="<?= site_url($locale . '/admin/pages/restore/' . $page->id); ?>" data-ajax-url="<?= site_url($locale . '/admin/pages') ?>">
								<i class="fas fa-undo-alt"></i> <?= lang('AdminPanel.restore') ?>
							</a>
						</span>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<?= $pager->links('group', 'pagination_admin'); ?>
			</td>
		</tr>
	</tfoot>
</table>
<?php
if (isset($is_ajax)) : ?>
	<script>
		$(function() {
			$('[data-tooltip="tooltip"]').tooltip();
		});
	</script>
<?php endif; ?>