<!--Slider-->
<style>
    d-none {
        display: none;
    } 
</style>
<div class="container position-relative">
    <section class="slider " id="slider-home">
        <?php if (isset($slides) && count($slides) > 0) : ?>
            <?php $index = 0 ?>
            <?php foreach ($slides as $slide) : ?>

                <div class="hold-img-slider <?php if ($index != 0) : ?> d-none <?php endif ?>">

                    <!-- снимка за мобилната !!! -->
                    <!-- <img src="/assets/images/bg/header-homepage-mobile.jpg" class="img-fluid img-slider-mobile" alt="slider">-->

                    <!--Link-->
                    <?php if (!empty($slide->link)) : ?>
                        <a href="<?= $slide->link ?>">
                            <img src="<?= $slide->image ?>" class="img-fluid img-slider" alt="<?= $slide->img_alt != "" ? $slide->img_alt : $slide->title ?>">
                        </a>
                    <?php else : ?>
                        <img src="<?= $slide->image ?>" class="img-fluid img-slider" alt="<?= $slide->img_alt != "" ? $slide->img_alt : $slide->title ?> ?>">
                    <?php endif; ?>

                    <div class="slider-description d-none">
                        <!--Title-->
                        <?php if (!empty($slide->title)) : ?>
                            <h2 class="slide-subtitle"><?= $slide->title; ?></h2>
                        <?php endif; ?>

                        <!--SubTitle-->
                        <?php if (!empty($slide->subtitle)) : ?>
                            <h1 class="slide-title"><?= $slide->subtitle; ?></h1>
                        <?php endif; ?>

                        <!--Content-->
                        <?php if (!empty($slide->content)) : ?>
                            <?= $slide->content; ?>
                        <?php endif; ?>

                    </div>
                </div>
                <?php $index++ ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <!--END Slider-->
    </section>

    <div class="main-slide-nav">
        <img src="/assets/images/icons/left.png" class="left-arrow-slder" alt="arrow preview">
        <img src="/assets/images/icons/left.png" class="right-arrow-slder" alt="arrow preview">
    </div>
</div>

<section class="home-icons">
    <div class="container">
        {section-1}
    </div>
</section>


<section class="home-about">
    <div class="container">
        {section-2}
    </div>
</section>


<section class="home-special-for-you">
    <div class="container">
        <div class="text-center">
            <h2 class="home-title2"><?= lang('AdminPanel.seasonOffer') ?></h2>
            <span class="strip-title"></span>
        </div>
        <div class="product-slide-special">
            <?= $selectionProducts ?>
        </div>
        <div class="category-slide-nav">
            <img src="/assets/images/icons/arrow-prev.png" class="left-arrow-slde3" alt="arrow preview">
            <img src="/assets/images/icons/arrow-next.png" class="right-arrow-slde3" alt="arrow preview">
        </div>
    </div>
</section>

<div class="container">
    <section class="subscribe">
        <div class="row row-sub-1 justify-content-end">
            <div class="col-xl-6 align-self-center left-side">
                {subs-1}
                <form class="needs-validation subscribe-form" novalidate method="post">
                    <div class="input-group">
                        <input type="text" class="form-control home-form email-input" name="email"
                               placeholder="<?= lang('AdminPanel.yourEmail') ?>" required>
                        <button class="btn btn-subscribe submit-subscribe" type="submit">
                            {subs-3}
                        </button>
                    </div>
                    <div class="warn-term">
                        <div class="form-group">
                            <div class="form-check">
                                <?php $randomNumber = rand(1000, 9999); ?>
                                <input id="warn<?= $randomNumber ?>" class="form-check-input warn-check" name="warn"
                                       type="checkbox" value="1" required>
                                <label for="warn<?= $randomNumber ?>" class="form-check-label text-white">
                                    {subs-2}
                                </label>
                            </div>

                        </div>
                    </div>
            </div>
            </form>
            <div class="subscribe-error alert alert-danger text-center d-none mt-2"></div>
            <div class="subscribe-success alert alert-success text-center d-none"></div>
        </div>
</div>
</section>
</div>

<section class="home-categories">
    <div class="container">
        {section-3}
    </div>
</section>


<section class="home-news">
    <div class="container">
        <div class="text-center">
            <h2 class="home-title2">{news-home-title}</h2>
            <span class="strip-title"></span>
        </div>
        <?= $articlesHomeBlock ?>
        <div class="see-all-new text-center"><a href=<?= site_url($locale . '/articles-all') ?>>{news-home-btn-all}</a></div>
    </div>
</section>

<!--Galleries Manufactures-->
<section class="home-news">
    <div class="container">
        <div class="text-center">
            <h2 class="home-title2">{news-home-title}</h2>
            <span class="strip-title"></span>
        </div>
        <?= $galleriesHomeBlock ?>
        '
        <div class="see-all-new text-center"><a href=<?= site_url($locale . '/galleries-all') ?>>{news-home-btn-all}</a></div>
    </div>
</section>

<!--Section Manufactures-->
<section class="manufactures">
    <div class="container">
        <div class="text-center">
            <h2 class="home-title2"><?= lang('AdminPanel.brandShop') ?></h2>
            <span class="strip-title"></span>
        </div>

        <div class="position-relative">
            <div class="slider-manufactures">
                <?php foreach ($brands as $brand) : ?>
                    <?php $imageDescription = json_decode($brand->images_description, true); ?>
                    <div class="m-item align-self-center">
                        <a href="<?= base_url($brand->link) ?>">
                            <img src="<?= base_url($brand->image) ?>" class="img-fluid img-logo-m"
                                 alt="<?= $imageDescription[0]['img_alt'] != "" ? $imageDescription[0]['img_alt'] : $brand->title ?>"
                                 title="<?= $brand->title ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="manu-arrow-group">
                <img src="<?= base_url('assets/images/icons/arrow-prev.png') ?>"
                     class="slider-arrow slider-m-arrow-left" alt="arrow">
                <img src="<?= base_url('assets/images/icons/arrow-next.png') ?>"
                     class="slider-arrow slider-m-arrow-right" alt="arrow">
            </div>
        </div>
    </div>
</section>
<!--Section Manufactures-->


<!--Section last_seen -->
<? //= $last_seen ?? '' 
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.hold-img-slider').removeClass('d-none');
    });
</script>
