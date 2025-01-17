<table class="table table-striped table-hover">
  <thead>
	  <tr>
		  <th> # </th>
		  <th><?= lang('AdminPanel.name') ?></th>
		  <th class="text-nowrap text-center"><?= lang('AdminPanel.status') ?></th>
		  
		  <th class="project-actions text-right text-nowrap" style="width: 36%"><?= lang('AdminPanel.action') ?></th>
	  </tr>
  </thead>
  <tbody>
	<?php if (count($elements) == 0):?>
		<tr id="row0">
			<td colspan="4" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
		</tr>
	<?php endif; ?>
	<?php foreach ($elements as $element):?>
	<tr id="row<?= $element->id ?>">
	  <td <?= (isset($lastEdidtedId) && $lastEdidtedId == $element->id) ? 'class="bg-primary"' : '' ?>>
		<?= $element->id ?>
	  </td>
	  
	  <td><?= $element->title ?></td>

	  <td class="project-state text-nowrap text-center">
		  <?php if ($element->active == 1):?>
			<span class="badge badge-success"><?=lang('AdminPanel.active')?></span>
		  <?php else:?>
			<span class="badge badge-danger"><?=lang('AdminPanel.inactive')?></span>
		  <?php endif;?>
	  </td>
	  
	  <td class="project-actions text-right text-nowrap">
	   <?php if ($element->deleted_at == '') : ?>
		<div class="btn-group float-right">
		  <a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/properties_categories/form/' . $element->id) ?>" data-id="properties_categories<?= $element->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/properties_categories') ?>">
			  <i class="fas fa-pencil-alt" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>"></i>
		  </a>
		  <a class="btn btn-secondary btn-sm edit-button" href="<?= site_url($locale . '/admin/properties_categories/form/' . $element->id . '/1') ?>" data-id="properties_categoriescopy<?= $element->id ?>"  data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/properties_categories') ?>">
			  <i class="fa fa-copy" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>"></i>
		  </a>
		  <a class="btn btn-danger btn-sm delete-button" href="<?php echo site_url($locale . '/admin/properties_categories/delete/' . $element->id); ?>" data-toggle="modal" data-target="#ModalConfirmAjax" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>" data-ajax-url="<?= site_url($locale . '/admin/properties_categories') ?>">
			<i class="fas fa-trash"></i>
		  </a>
		</div>
		 <?php else:?>
			<a class="btn btn-primary btn-sm process-button" href="<?= site_url($locale . '/admin/properties_categories/restore/' . $element->id) ?>" data-ajax-url="<?= site_url($locale . '/admin/properties_categories') ?>">
				<i class="fas fa-undo-alt"></i> <?= lang('AdminPanel.restore') ?>
			</a>
		  <?php endif;?>
	  </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
  <tfoot>
	<tr>
	  <td colspan="6">
		<?php if ($deleted != 'deleted') echo $pager->links('group', 'pagination_admin'); ?>
	  </td>
	</tr>
  </tfoot>
</table>
<?php 
if (isset($is_ajax)) :?>
<script>
$(function() {
	$('[data-tooltip="tooltip"]').tooltip();
});
</script>
<?php endif; ?>