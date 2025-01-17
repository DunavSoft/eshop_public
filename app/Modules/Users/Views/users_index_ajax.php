<table class="table table-responsive table-striped table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width: 1%">
                #
            </th>
            <th>
                <?= lang('AdminPanel.email') ?>
            </th>
            <th class="text-center">
                <?= lang('UsersLang.name') ?>
            </th>
            <th class="text-center">
                <?= lang('UsersLang.start_turnover') ?>
            </th>
            <th class="text-center">
                <?= lang('UsersLang.turnover') ?>
            </th>
            <th class="text-center">
                <?= lang('UsersLang.loyalclient') ?>
            </th>
            <th class="text-center">
                <?= lang('UsersLang.active') ?>
            </th>

            <th class="project-actions text-right"><?= lang('AdminPanel.action') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($elements) == 0) : ?>
            <tr id="row0">
                <td colspan="8" class="text-center"><?= lang('AdminPanel.noRecordsFound') ?></td>
            </tr>
        <?php endif; ?>
        <?php foreach ($elements as $element) : ?>
            <tr id="row<?= $element->id ?>">
                <td <?= (isset($lastEdidtedId) && $lastEdidtedId == $element->id) ? 'class="bg-primary text-nowrap text-center"' : '' ?>>
                    <?= $element->id ?>
                </td>
                <td><?= $element->email ?></td>
                <td class="text-center"><?= $element->firstname ?> <?= $element->lastname ?></td>
                <td class="text-center"><?= $element->start_turnover ?> лв.</td>
                <td class="text-center"><?= $element->turnover ?> лв.</td>
                <td class="text-center"><?= $element->percent_loyalclient ?> %</td>
                <td class="text-center">
                    <?php if ($element->active == 1) : ?>
                        <span class="badge badge-success"><?= lang('AdminPanel.active') ?></span>
                    <?php else : ?>
                        <span class="badge badge-danger"><?= lang('AdminPanel.inactive') ?></span>
                    <?php endif; ?>
                </td>

                <td class="project-actions text-right text-nowrap">
                    <div class="btn-group float-right">
                        <?php if ($deleted == false) : ?>
                            <a class="btn btn-primary btn-sm edit-button" href="<?= site_url($locale . '/admin/users/form/' . $element->id) ?>" data-id="users<?= $element->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/users') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.edit') ?>">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="btn btn-secondary btn-sm edit-button" href="<?= site_url($locale . '/admin/users/form/' . $element->id . '/1') ?>" data-id="userscopy<?= $element->id ?>" data-toggle="modal" data-target="#ModalFormSecondary" data-ajax-url="<?= site_url($locale . '/admin/users') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.copy') ?>">
                                <i class="fa fa-copy"></i>
                            </a>
                            <a class="btn btn-danger btn-sm delete-button" href="<?php echo site_url($locale . '/admin/users/delete/' . $element->id); ?>" data-toggle="modal" data-target="#ModalConfirmAjax" data-ajax-url="<?= site_url($locale . '/admin/users') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.delete') ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        <?php else : ?>
                            <a class="btn btn-primary btn-sm process-button" href="<?php echo site_url($locale . '/admin/users/restore/' . $element->id); ?>" data-ajax-url="<?= site_url($locale . '/admin/users') ?>">
                                <i class="fas fa-undo"></i> <?= lang('AdminPanel.restore') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">
                <?php if ($deleted != true) echo $pager->links('group', 'pagination_admin'); ?>
            </td>
        </tr>
    </tfoot>
</table>
<?php
if (isset($isAjax) && $isAjax) : ?>
    <script>
        $(function() {
            $('[data-tooltip="tooltip"]').tooltip();
        });
    </script>
<?php endif; ?>