<section class="page-header d-none">
    <div class="container">
        <div class="cat-subtitle">
            <h1 class="home-title2"><?= $page->title?? '404' ?></h1>
        </div>
    </div>
</section>
<?php if (isset($page)): ?>
    <section style="position: relative" class="page-details">
        <div class="container">
            <h1 class="home-title2"><?= $page->title ?? '404' ?></h1>

            <div class="breadcrumb">
                <a href="<?= site_url($locale . '/') ?>" class="breadcrumb-item"><?= lang('AdminPanel.home') ?></a>
                <?php foreach ($breadcrumb as $key => $breadcrumbItem): ?>
                    <?php if ($key === array_key_last($breadcrumb)): ?>
                        <i class="fa fa-chevron-right"></i>
                        <strong class="accent"><?= $breadcrumbItem['title'] ?></strong>
                    <?php else: ?>
                        <i class="fa fa-chevron-right"></i>
                        <a href="<?= site_url($locale . '/' . $breadcrumbItem['slug']) ?>" class="breadcrumb-item"><?= $breadcrumbItem['title'] ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <p><?= $page->content ?? '{404_text}' ?></p>
        </div>
    </section>
<?php else: ?>
    <div style="padding: 60px 15px">
        <div class="container">
            <?= $page->content ?? '{404_text}' ?>
        </div>
    </div>
<?php endif; ?>