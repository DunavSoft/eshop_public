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

// to prevent displaying page = 1
$previousPage = $pager->getPreviousPage();

if ($current == 2) {
	$cleanURI = str_replace(site_url(), '', $previousPage);
	$segments = explode('/', $cleanURI);
	unset($segments[count($segments) - 1]);
	$previousPage = site_url(implode('/', $segments));
}
?>
<?php if ($total > 1) : ?>

	<div id="paginator" class="col-md-12 text-center">
		<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
			<ul class="pagination ">
				<?php if ($current > 1) : ?>
					<li class="page-item">
						<a class="page-link border-0" href="<?= $previousPage ?>" aria-label="<?= lang('Pager.previous') ?>">
							<span aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
						</a>
					</li>
				<?php endif ?>

				<?php foreach ($pager->links() as $link) : ?>
					<?php
					//remove /1 from page uri
					$cleanURI = str_replace(site_url(), '', $link['uri']);
					$segments = explode('/', $cleanURI);
					if ($segments[count($segments) - 1] == 1) {
						unset($segments[count($segments) - 1]);
						$link['uri'] = site_url(implode('/', $segments));
					}
					?>
					<li class="page-item">
						<?php if (!$link['active']) : ?>
							<a class="page-link<?= $link['active'] ? ' active' : '' ?>" href="<?= $link['uri'] ?>">
								<?= $link['title'] ?>
							</a>
						<?php else : ?>
							<a class="page-link page-link-active" href="javascript:">
								<?= $link['title'] ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach ?>

				<?php if ($pager->hasNext()) : ?>
					<li class="page-item">
						<a class="page-link border-0" href="<?= $pager->getNextPage() ?>" aria-label="<?= lang('Pager.next') ?>">
							<span aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
						</a>
					</li>
				<?php endif ?>
			</ul>
		</nav>
	</div>
<?php endif; ?>