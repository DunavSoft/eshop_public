<table class="table table-responsive table-striped table-hover">
	<thead>
		<tr>
			<th class="text-center" style="width: 1%">
				#
			</th>

			<th>
				<?= lang('SubscriptionsLang.email') ?>
			</th>

			<th class="text-center">
				<?= lang('SubscriptionsLang.name') ?>
			</th>

			<th class="text-nowrap text-center">
				<?= lang('SubscriptionsLang.phone') ?>
			</th>

			<th class="text-nowrap text-center">
				<?= lang('AdminPanel.status') ?>
			</th>

			<th class="text-nowrap text-center">
				<?= lang('SubscriptionsLang.date') ?>
			</th>

			<th class="project-actions text-right text-nowrap"><?= lang('AdminPanel.action') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($elements) == 0) : ?>
			<tr id="row0">
				<td colspan="7" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
			</tr>
		<?php endif; ?>
		<?php foreach ($elements as $element) : ?>
			<tr>
				<td <?= (isset($lastEdidtedId) && $lastEdidtedId == $element->id) ? 'class="bg-primary text-nowrap text-center"' : '' ?>>
					<?= $element->id ?>
				</td>

				<td>
					<?= $element->email ?>
				</td>

				<td class="text-center">
					<?= $element->name ?>
				</td>

				<td class="text-nowrap text-center">
					<?= $element->phone ?>
				</td>

				<td class="project-state text-nowrap text-center">
					<?php if ($element->active == 1) : ?>
						<span class="badge badge-success"><?= lang('AdminPanel.active') ?></span>
					<?php else : ?>
						<span class="badge badge-danger"><?= lang('AdminPanel.inactive') ?></span>
					<?php endif; ?>
				</td>

				<td class="text-nowrap text-center">
					<?= date('d.m.Y H:i', $element->created_at) ?>
				</td>

				<td class="text-right text-nowrap">
					<a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/users/subscriptions/form/' . $element->id) ?>" data-id="subscriptions<?= $element->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/users/subscriptions') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>">
						<i class="fas fa-pencil-alt"></i>
					</a>
				</td>

			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $pager->links('group', 'pagination_admin'); ?>
			</td>
		</tr>
	</tfoot>
</table>
<?php
if (isset($isAjaxRequest)) : ?>
	<script>
		$(function() {
			$('[data-tooltip="tooltip"]').tooltip();
		});
	</script>
<?php endif; ?>