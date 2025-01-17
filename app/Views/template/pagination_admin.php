<?php
$current = 0;
$i = 0;
foreach ($pager->links() as $link) {
	$i++;
	if ($link['active']) {
		$current = $i;
	}
}

$total = count($pager->links());

$pager->setSurroundCount(2);
if (!$pager->hasPrevious()) {
	$pager->setSurroundCount(4 - $current + 1);
}

if (($total - $current) < 2) {
	$pager->setSurroundCount(4 - ($total - $current));
}
?>
<?php if ($total > 1) :?>
<div class="paging text-center">
	<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
		<ul class="pagination justify-content-center">
			<?php if ($current > 1) : ?>
				<li class="page-item">
					<a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
						<span aria-hidden="true"><?= lang('Pager.first') ?></span>
					</a>
				</li>
				
				<li class="page-item">
					<a class="page-link" href="<?= $current - 1 ?>" aria-label="<?= lang('Pager.previous') ?>">
						<span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
					</a>
				</li>
			<?php endif ?>

			<?php foreach ($pager->links() as $link) : ?>
				<li class="page-item">
					<?php if (!$link['active']) : ?>
					<a class="page-link<?= $link['active'] ? ' active' : '' ?>" href="<?= $link['uri'] ?>">
						<?= $link['title'] ?>
					</a>
					<?php else: ?>
					<a class="page-link page-link-active" href="javascript:">
						<?= $link['title'] ?>
					</a>
					<?php endif;?>
				</li>
			<?php endforeach ?>

			<?php if ($pager->hasNext()) : ?>
				<li class="page-item">
					<a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>">
						<span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
					</a>
				</li>
				
				<li class="page-item">
					<a class="page-link" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
						<span aria-hidden="true"><?= lang('Pager.last') ?></span>
					</a>
				</li>
			<?php endif ?>
		</ul>
	</nav>
</div>
<?php endif;?>