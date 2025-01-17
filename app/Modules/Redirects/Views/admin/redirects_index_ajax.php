<table class="table table-striped table-hover">
  <thead>
	  <tr>
		  <th>
			  #
		  </th>
		  <th><?= lang('RedirectsLang.source') ?></th>
		  <th><?= lang('RedirectsLang.target') ?></th>
		  <th class="text-nowrap text-center"><?= lang('RedirectsLang.code') ?></th>
		  
		  <th class="project-actions text-right text-nowrap"><?= lang('AdminPanel.action') ?></th>
	  </tr>
  </thead>
  <tbody>
	<?php if (count($elements) == 0):?>
		<tr id="row0">
			<td colspan="5" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
		</tr>
	<?php endif; ?>
	<?php foreach ($elements as $element):?>
	<tr id="row<?= $element->id ?>">
	  <td <?= (isset($lastEdidtedId) && $lastEdidtedId == $element->id) ? 'class="bg-primary"' : '' ?>>
		<?= $element->id ?>
	  </td>
	  <td><?= $element->source ?></td>
	  <td><?= $element->target ?></td>
	  <td class="text-center"><?= $element->code ?></td>
	  <td class="project-actions text-right text-nowrap">
	   <?php if ($element->deleted_at == '') : ?>
		<div class="btn-group float-right">
		  <a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/redirects/form/' . $element->id) ?>" data-id="redirects<?= $element->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>" data-ajax-url="<?= site_url($locale . '/admin/redirects') ?>">
			<i class="fas fa-pencil-alt"></i>
		  </a>
		  <a class="btn btn-secondary btn-sm edit-button" href="<?= site_url($locale . '/admin/redirects/form/' . $element->id . '/1') ?>" data-id="redirectscopy<?= $element->id ?>"  data-toggle="modal" data-target="#ModalFormSecondary" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>" data-ajax-url="<?= site_url($locale . '/admin/redirects') ?>">
			<i class="fa fa-copy"></i> 
		  </a>
		  <a class="btn btn-danger btn-sm delete-button" href="<?php echo site_url($locale . '/admin/redirects/delete/' . $element->id); ?>" data-toggle="modal" data-target="#ModalConfirmAjax" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>" data-ajax-url="<?= site_url($locale . '/admin/redirects') ?>">
			<i class="fas fa-trash"></i>
		  </a>
		</div>
		 <?php else:?>
			<a class="btn btn-primary btn-sm process-button" href="<?= site_url($locale . '/admin/redirects/restore/' . $element->id) ?>" data-ajax-url="<?= site_url($locale . '/admin/redirects') ?>">
				<i class="fas fa-undo-alt"></i> <?= lang('AdminPanel.restore') ?>
			</a>
		  <?php endif;?>
	  </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
  <tfoot>
	<tr>
	  <td colspan="5">
		<?php if ($deleted != 'deleted') echo $pager->links('group', 'pagination_admin'); ?></td>
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