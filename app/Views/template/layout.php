<!DOCTYPE html>
<html lang="<?= $locale ?? 'bg' ?>">

<head>
    <meta charset="UTF-8">
    <title><?= $seo_title ?? '{meta_site_title}' ?></title>

    <meta name="description" content="<?= $meta ?? '{meta_site_description}' ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <?php if (isset($canonical) && $canonical != '') : ?>
        <link rel="canonical" href="<?= $canonical ?>" />
    <?php endif ?>

    <!--   Custom CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom_select.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages.css') ?>">

    <!-- cart -->
    <link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">

    <!--   Cookies CSS-->
    <link rel="stylesheet" href="<?= base_url('assets/css/cookies_agreement.css') ?>">

    <!--    Slick Slider-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/slick.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/slick-theme.css') ?>" />

    <!--   Fancybox gallery-->
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.fancybox.css') ?>">

    <!--    Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Fontawesome-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="robots" content="index,follow">

    <meta property="og:url" content="<?= $seo_url ?? '{seo_url}' ?>" />
    <meta property="og:title" content="<?= $seo_title ?? '{meta_site_name}' ?>" />
    <meta property="og:description" content="<?= $meta ?? '{meta_site_description}' ?>" />
    <meta property="og:image" content="<?= base_url($image ?? 'og_image.jpg') ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="<?= $article ?? 'website' ?>" />

    <meta name="twitter:title" content="<?= $seo_title ?? '{meta_site_name}' ?>" />
    <meta name="twitter:description" content="<?= $meta ?? '{meta_site_description}' ?>" />
    <meta name="twitter:image" content="<?= base_url($image ?? 'og_image.jpg') ?>" />
    <meta name="twitter:site" content="summary_large_image" />

    <script>
        // Define dataLayer and the gtag function.
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        // Set default consent to 'denied' as a placeholder
        // Determine actual values based on your own requirements
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied'
        });
    </script>

    {google_analytics_one}
</head>

<body <?php if (isset($is_home)) : ?>class="d-none" <?php endif; ?>>
    <div class="promo-strip">
        {promo_strip}
    </div>

    <header id="header" class="align-self-center">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5 col-soc align-self-center">
                    <div class="list-inline-item search-bar">
                        <form id="searchform1" class="form-inline" action="<?= site_url($locale . '/find') ?>" role="search">
                            <div class="position-relative">
                                <input class="form-control mr-sm-2" type="text" id="search" name="search" autocomplete="off" value="<?= isset($searchString) ? $searchString : '' ?>">
                                <button class="search-icon searchbtn" type="submit">
                                    <img src="<?= base_url('assets/images/icons/search.svg') ?>" class="search-icon" alt="search">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-2 col-3 align-self-center col-nav text-center">
                    <a href="<?= site_url($locale . '/') ?>" class="wrap-logo">
                        <img src="<?= base_url('assets/images/logo_bonito.svg') ?>" class="site-logo" alt="logo">
                    </a>
                </div>

                <div class="col-lg-5 col-9 col-shop align-self-center text-end">
                    <ul class="list-inline list-unstyled m-0 ul-list-header">
                        <li class="list-inline-item li-fav d-none">
                            <a href="<?= site_url($locale . '/favorites') ?>">
                                <img src="<?= base_url('assets/images/icons/favourites.svg') ?>" class="shop-icon fav-icon" alt="search">
                            </a>
                        </li>

                        <li class="list-inline-item d-xxl-none d-xl-none d-lg-none">
                            <div class="search-icon" onclick="openSearch()">
                                <img src="<?= base_url('assets/images/icons/search.svg') ?>" class="search-icon" alt="search">
                            </div>
                        </li>

                        <?php if (!session()->has('isLoggedIn') && !session()->isLoggedIn) : ?>
                            <li class="list-inline-item li-user">
                                <a href="<?= site_url($locale . '/users/login') ?>" class="<?= isset($activeMenuItem) && $activeMenuItem === 'login' ? 'active' : '' ?>">
                                    <img src="<?= base_url('assets/images/icons/user.svg') ?>" class="shop-icon user-icon" alt="user">
                                </a>
                            </li>
                        <? else : ?>
                            <li class="list-inline-item li-user">
                                <a href="<?= site_url($locale . '/users/myaccount') ?>">
                                    <img src="<?= base_url('assets/images/icons/user.svg') ?>" class="shop-icon user-icon" alt="user">

                                    <a href="<?= site_url($locale . '/users/logout') ?>">
                                        <span class="user-text"><i class="fa fa-sign-out" title="Изход"></i> </span>
                                    </a>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="list-inline-item li-cart">
                            <a href="<?= site_url($locale . '/cart') ?>">
                                <img src="<?= base_url('assets/images/icons/shopping-cart.svg') ?>" class="shop-icon cart-icon" alt="cart">
                                <div class="cart-count" id="cart_total_items">{{cart_total_items}}</div>
                            </a>
                        </li>

                        <li class="list-inline-item li-info">
                            <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <img src="<?= base_url('assets/images/icons/info2.svg') ?>" class="shop-icon info-icon" alt="info">
                            </a>
                            <div class="dropdown-menu info-menu-drop" role="menu" data-bs-popper="none">
                                <ul class="list-unstyled info-menu">
                                    {{info_menu}}
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="row margin-0">
        <div class="col-md-12">
            <div id="myOverlay" class="overlay">
                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                <div class="overlay-content">
                    <form id="searchform2" class="form-inline" action="<?= site_url($locale . '/find') ?>" role="search">
                        <div class="input-group ig-search">
                            <div class="input-group-btn">
                                <input class="form-control searchcontrol" type="text" name="search" value="<?= isset($searchString) ? $searchString : '' ?>">
                                <button class="btn btn-default searchbtn" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="menu ">
            <div class="row">
                <div class="col-sm-12">
                    <button class="navbar-toggler toggle-menu d-lg-none" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" type="button">
                        <span></span>
                    </button>

                    <nav class="navbar navbar-expand-lg">
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= site_url($locale . '/') ?>" target="_self">
                                        <img src="<?= base_url('assets/images/icons/home.svg') ?>" class="home-icon" alt="home">
                                    </a>
                                </li>
                                {{category_menu}}
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php
    try {
        echo view($view);
    } catch (Exception $e) {
        echo "<pre><code>$e</code></pre>";
    }
    ?>

    <?php
    $actual_link = "$_SERVER[REQUEST_URI]";
    $page = explode("/", $actual_link);
    ?>

    <!--    --><?php //if ($page[1] != "") : 
                ?>
    <section class="newsletter2">
        <div class="row">
            <div class="col-xxl-3 col-lg-4 ns-col-1 align-self-center">
                <div class="ns-1">
                    <img src="/assets/images/icons/newsletter.svg" class="ns-icon" alt="newsletter">
                    <p><?= lang('AdminPanel.subscribe') ?> <br> <?= lang('AdminPanel.bulletin') ?></p>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-3 align-self-center">
                <div class="ns-2">
                    <p>
                        <?= lang('AdminPanel.promotionsLearn') ?>
                        <br>
                        <?= lang('AdminPanel.offersLearn') ?>
                    </p>
                </div>
            </div>
            <div class="col-xxl-6 col-lg-5 subscribe">
                <form class="needs-validation subscribe-form" novalidate method="post">
                    <div class="input-group">
                        <input type="email" class="form-control home-form" name="email" placeholder="<?= lang('LandLang.yourEmail') ?>" style="border: 1px solid #c3c3c3 !important;" required>
                        <button class="btn btn-subscribe submit-subscribe" type="submit">
                            {subs-3}
                        </button>
                    </div>
                    <div class="warn-term">
                        <div class="form-check">
                            <?php $randomNumber = rand(1000, 9999); ?>
                            <input class="form-check-input" name="warn" type="checkbox" value="1" id="warn<?= $randomNumber ?>" style="border: 1px solid #c3c3c3 !important;border-radius: 0;" required>
                            <label class=" form-check-label" for="warn<?= $randomNumber ?>">
                                {subs-2}
                            </label>
                        </div>
                    </div>
                </form>
                <div class="subscribe-error alert alert-danger text-center d-none mt-2"></div>
                <div class="subscribe-success alert alert-success text-center d-none"></div>
            </div>
        </div>
    </section>
    <!--    --><?php //endif 
                ?>
    <!--GDPR MESSAGE-->
    <!-- Cookie consent notification -->
    <div id="cookieConsent" class="cookie-consent d-none">
        <div class="container">
            <p>{gdpr_text}</p>
            <button class="btn btn-default" id="cookie-config"><i class="fa fa-cog"></i>&nbsp;{gdpr_title}</button>
            <form id="cookieForm">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="ad_storage">
                    <label class="form-check-label" for="ad_storage">
                        <strong>ad_storage</strong>
                        <small>{ad_storage}</small>
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="ad_user_data">
                    <label class="form-check-label" for="ad_user_data">
                        <strong>ad_user_data</strong>
                        <small>{ad_user_data}</small>
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="ad_personalization">
                    <label class="form-check-label" for="ad_personalization">
                        <strong>ad_personalization</strong>
                        <small>{ad_personalization}</small>
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="analytics_storage">
                    <label class="form-check-label" for="analytics_storage">
                        <strong>analytics_storage</strong>
                        <small>{analytics_storage}</small>
                    </label>
                </div>

                <button onclick="acceptCookies()" id="cookie-btn">{accept_cookies}</button>
            </form>
            <button id="checkAllButton" onclick="acceptAll()">{accept_all}</button>
            <button id="uncheckAllButton" onclick="rejectAll()">{reject_all}</button>
        </div>
    </div>
    <!--END GDPR MESSAGE-->

    <a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
    <footer>
        <div class="container">
            <div class="row justify-content-evenly">
                <div class="col-xxl-2 col-xl-2">
                    <a href="<?= site_url($locale . '/') ?>">
                        <img src="<?= base_url('assets/images/logo_bonito_white.svg') ?>" class="logo-footer" alt="logo">
                    </a>
                </div>
                <div class="col-xxl-2 col-xl-2">
                    <p class="f-title"><?= lang('AdminPanel.products') ?></p>
                    {{products}}

                </div>
                <div class="col-xxl-2 col-xl-2">
                    <p class="f-title"><?= lang('AdminPanel.helpful') ?></p>
                    {{usefull}}
                </div>

                <div class="col-xxl-3 col-xl-3">
                    <p class="f-title"><?= lang('AdminPanel.yourBonito') ?></p>
                    {{bonito}}
                </div>
                <div class="col-xxl-3 col-xl-3">
                    <p class="f-title"><?= lang('AdminPanel.contactUs') ?></p>
                    {footer_contacts}
                </div>
            </div>

            <hr style="opacity: 1; border-bottom: 1px solid #444444; background: #444444">

            <div class="copyright">
                <div class="row">
                    <div class="col-xl-6">
                        <p>{text_copyrights}</p>
                    </div>
                    <div class="col-xl-6 text-end">
                        {text_privacy}
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!--JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/slick.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.fancybox.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/validator.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/custom_select.js') ?>"></script>

    <?php include(APPPATH . 'Modules\Search\Views\search_results_front_js.php'); ?>

    <!-- Google ads events -->
    <script type="text/javascript" src="<?= base_url('assets/js/google_ads_checkout_events.js') ?>"></script>

    <script type="text/javascript" src="<?= base_url('assets/js/pages.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/pagination.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.creditCardValidator.js') ?>"></script>

    <script type="text/javascript" src="<?= base_url('admin_panel/plugins/select2/js/select2.full.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/bg.js"></script>

    <!-- Cookies -->
    <script src="<?= base_url('assets/js/cookies_agreement.js') ?>"></script>

    <!-- ckeditor -->
    <script type="text/javascript" src="<?= base_url('admin_panel/plugins/ckeditor/ckeditor.js'); ?>"></script>

    <?php
    if (isset($moduleJS)) {
        try {
            if (is_array($moduleJS)) {
                foreach ($moduleJS as $js) {
                    echo view($js);
                }
            } else {
                echo view($moduleJS);
            }
        } catch (Exception $e) {
            echo "<pre><code>$e</code></pre>";
        }
    }

    echo view('App\Views\validation_messages', [
        'locale' => $locale ?? 'bg'
    ]);

    echo view('App\Modules\Land\Views\subscribe_modal', [
        'locale' => $locale ?? 'bg'
    ]);

    echo view('App\Modules\Land\Views\home_js', [
        'locale' => $locale ?? 'bg'
    ]);
    ?>

    <!-- {{filter_js}} -->
    <!-- {{iban_js}} -->

    <script type="text/javascript">
        var editor_config = {
            allowedContent: true,
            removeButtons: 'Flash,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Iframe,Language,NewPage,Templates,SelectAll,SpellChecker,Paste,PasteText'
        };

        $(".ckeditor").each(function(index, formtextarea) {
            if (formtextarea.id == '') {
                $(formtextarea).attr('id', 'myckeditorcustomid' + index);
            }

            var editor = CKEDITOR.replace(formtextarea.id, editor_config);

            CKFinder.setupCKEditor(editor, '<?= site_url('admin_panel/plugins/ckeditor/ckfinder'); ?>');
        });
    </script>
</body>
</html>