<section class="page-details">
    <div class="container">
        <h1 class="home-title2"><?= $category_title ?? '{404_title}' ?></h1>
        <div class="row">
            <?php
            try {
                echo view('App\Modules\Galleries\Views\galleries_list_elements');
            } catch (Exception $e) {
                echo "<pre><code>$e</code></pre>";
            }
            ?>
        </div>
        <?= $pager->links('group', 'pagination_full'); ?>
    </div>
</section>