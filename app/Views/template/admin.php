<?php
//last change: 2023-03-04 GN
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $pageTitle; ?></title>

  <link rel="icon" type="image/x-icon" href="<?= base_url('admin_panel/dist/img/favicon.ico') ?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/select2/css/select2.min.css') ?>" />

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/jqvmap/jqvmap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">

  <!-- jquery-ui -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/jquery-ui/jquery-ui.min.css') ?>">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/plugins/daterangepicker/daterangepicker.css') ?>">

  <!-- custom css -->
  <link rel="stylesheet" href="<?= base_url('admin_panel/dist/css/custom.css') ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php // d($this->loader->getClassname(APPPATH . 'Modules/Galleries/Controllers/GalleriesController.php'));
    ?>
    <?php $configApp = new \Config\App(); ?>
    <?php isset($activeMenu) ? $activeMenu : $activeMenu = []; ?>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <?php /*
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=site_url($locale . '/admin/dashboard')?>" class="nav-link"><?=lang('AdminPanel.home')?></a>
      </li>
	  */ ?>

        <?php $segmentsArray = service('uri')->getSegments(); ?>
        <?php $uriPath = service('uri')->getPath(); ?>
        <?php $uriPath = str_replace($locale . '/', '', $uriPath); ?>

        <?php foreach ($languagesAdmin as $lang) : ?>
          <li class="nav-item d-none d-sm-inline-block">
            <?php if ($lang->uri == $locale) : ?>
              <a href="#" class="nav-link active"><?= $lang->native_name ?></a>
            <?php else : ?>
              <a href="<?= site_url($lang->uri . '/' . $uriPath) ?>" class="nav-link"><?= $lang->native_name ?></a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- SEARCH FORM -->
      <?php if (isset($useSearch)) : ?>
        <form id="search_form" class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="<?= lang('AdminPanel.search') ?>" aria-label="<?= lang('AdminPanel.search') ?>" name="top-search-text" id="top-search-text">
            <div class="input-group-append">
              <button class="btn btn-navbar" id="top-search-button">
                <i class="fas fa-search" data-tooltip="tooltip" title="<?= lang('AdminPanel.search') ?>"></i>
              </button>
            </div>
          </div>
        </form>
      <?php endif; ?>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <?php /*
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/admin_panel/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>


          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
	  */ ?>

        <!-- Notifications Dropdown Menu -->
        <!--
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
	  -->

        <li class="nav-item">
          <span class="nav-link">
            <?php echo session('userAdminData')['name']; ?>
          </span>
        </li>

        <li class="nav-item">
          <a href="<?= site_url($locale . '/admin/logout') ?>" data-tooltip="tooltip" title="<?= lang('AdminPanel.logout') ?>" class="text-danger nav-link"><i class="fas fa fa-sign-in-alt"></i></a>
        </li>
        <?php /*
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
	   */ ?>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Brand Logo -->
      <?php if (in_array('Dashboard', $configApp->loadedModules)) : ?>
        <a href="<?= site_url($locale . '/admin/dashboard') ?>" class="brand-link <?= in_array($activeMenu, ['dashboard']) ? 'active' : '' ?>">
          <img class="brand-image" src="<?= base_url('admin_panel/dist/img/admin_panel_logo_s.png') ?>" height="30"> <span class="brand-text font-weight-light"><?= lang('AdminPanel.adminPanel') ?></span>
        </a>
      <?php endif; ?>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-2 pb-2 mb-2 d-flex">
          <div class="image">
            <a href="<?= site_url() ?>" target="_blank"><i class="nav-icon fa fa-home mt-2 ml-2 text-primary"></i></a>
          </div>
          <div class="info">
            <a href="<?= site_url() ?>" target="_blank"><?= lang('AdminPanel.toSite') ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <?php if (in_array($activeMenu, ['pages', 'galleries', 'sliders'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  <?= lang('AdminPanel.content') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/pages') ?>" class="nav-link <?= in_array($activeMenu, ['pages']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.pages') ?></p>
                  </a>
                </li>

                <?php if (in_array('Galleries', $configApp->loadedModules)) : ?>
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/galleries') ?>" class="nav-link <?= in_array($activeMenu, ['galleries']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('GalleriesLang.pageTitle') ?></p>
                    </a>
                  </li>
                <?php endif; ?>

                <?php if (in_array('Sliders', $configApp->loadedModules)) : ?>
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/sliders') ?>" class="nav-link <?= in_array($activeMenu, ['sliders']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>

                      <p><?= lang('SlidersLang.pageTitle') ?></p>
                    </a>
                  </li>
                <?php endif; ?>

              </ul>
            </li>

            <?php if (in_array($activeMenu, ['products', 'categories', 'coupons'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <!-- TODO: open if is active one of subitems -->
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  <?= lang('AdminPanel.products') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/products') ?>" class="nav-link <?= in_array($activeMenu, ['products']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.products') ?></p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/categories') ?>" class="nav-link <?= in_array($activeMenu, ['categories']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.categories') ?></p>
                  </a>
                </li>

                <?php if (in_array('Coupons', $configApp->loadedModules)) : ?>
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/coupons') ?>" class="nav-link <?= in_array($activeMenu, ['coupons']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('CouponsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                <?php endif; ?>

              </ul>
            </li>

            <?php if (in_array($activeMenu, ['orders', 'reports', 'transactions'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  <?= lang('AdminPanel.shop') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/orders') ?>" class="nav-link <?= in_array($activeMenu, ['orders']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.orders') ?></p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/transactions') ?>" class="nav-link <?= in_array($activeMenu, ['transactions']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.transactions') ?></p>
                  </a>
                </li>
              </ul>   
            </li>

            <?php if (in_array($activeMenu, ['reports_products', 'reports_clients'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                  <?= lang('ReportsLang.menuTitle') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/reports/products') ?>" class="nav-link <?= in_array($activeMenu, ['reports_products']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('ReportsLang.reportProducts') ?></p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/reports/clients') ?>" class="nav-link <?= in_array($activeMenu, ['reports_clients']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('ReportsLang.reportClients') ?></p>
                  </a>
                </li>
              </ul>
            </li>

            <?php if (in_array('Articles', $configApp->loadedModules)) : ?>
              <?php if (in_array($activeMenu, ['articles', 'articles_categories'])) $open = true;
              else $open = false; ?>
              <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-newspaper"></i>
                  <p>
                    <?= lang('ArticlesLang.pageTitle') ?>
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/articles') ?>" class="nav-link <?= in_array($activeMenu, ['articles']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>

                      <p><?= lang('ArticlesLang.articlesList') ?></p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/articles/categories') ?>" class="nav-link <?= in_array($activeMenu, ['articles_categories']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>

                      <p><?= lang('ArticlesCategoriesLang.pageTitle') ?></p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (in_array('DynamicForms', $configApp->loadedModules)) : ?>
              <?php if (in_array($activeMenu, ['dynamic_forms', 'dynamic_forms_answers'])) $open = true;
              else $open = false; ?>
              <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-question"></i>
                  <p>
                    <?= lang('AdminPanel.dynamicForms') ?>
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/dynamic_forms') ?>" class="nav-link <?= in_array($activeMenu, ['dynamic_forms']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.dynamicFormsList') ?></p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/dynamic_forms/answers') ?>" class="nav-link <?= in_array($activeMenu, ['dynamic_forms_answers']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.dynamicFormsAnswers') ?></p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (in_array('Users', $configApp->loadedModules)) : ?>
              <?php if (in_array($activeMenu, ['users', 'subscriptions'])) $open = true;
              else $open = false; ?>
              <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
                <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    <?= lang('AdminPanel.customers') ?>
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/users') ?>" class="nav-link <?= in_array($activeMenu, ['users']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.customers') ?></p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/users/subscriptions') ?>" class="nav-link <?= in_array($activeMenu, ['subscriptions']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.subscriptions') ?></p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (in_array($activeMenu, ['sizes', 'colors', 'properties_categories', 'properties', 'shopsettings', 'brands', 'shipping', 'payments', 'loyalclients', 'BuyAndSave' , 'countries', 'countries_prices'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fa fa-cogs"></i>
                <p>
                  <?= lang('AdminPanel.shop_settings') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <?php if (in_array('ShopSettings', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/shopsettings') ?>" class="nav-link <?= in_array($activeMenu, ['shopsettings']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('ShopSettingsLang.moduleTitle') ?></p>
                    </a>
                  </li>

                </ul>
              <?php endif; ?>

              <?php if (in_array('Brands', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/brands') ?>" class="nav-link <?= in_array($activeMenu, ['brands']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('BrandsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Sizes', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/sizes') ?>" class="nav-link <?= in_array($activeMenu, ['sizes']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('SizesLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Colors', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/colors') ?>" class="nav-link <?= in_array($activeMenu, ['colors']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('ColorsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('LoyalClients', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/loyalclients') ?>" class="nav-link <?= in_array($activeMenu, ['loyalclients']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('LoyalClientsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>
      
              <?php if (in_array('BuyAndSave', $configApp->loadedModules)) : ?>           
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/buyandsave') ?>" class="nav-link <?= in_array($activeMenu, ['BuyAndSave']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('BuyAndSaveLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>
              

              <?php if (in_array('Properties', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/properties_categories') ?>" class="nav-link <?= in_array($activeMenu, ['properties_categories']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('PropertiesCategoriesLang.moduleTitle') ?></p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/properties') ?>" class="nav-link <?= in_array($activeMenu, ['properties']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('PropertiesLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Shipping', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/shipping') ?>" class="nav-link <?= in_array($activeMenu, ['shipping']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('ShippingLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Payments', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/payments') ?>" class="nav-link <?= in_array($activeMenu, ['payments']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('PaymentsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Countries', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/countries') ?>" class="nav-link <?= in_array($activeMenu, ['countries']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('CountriesLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/countries_prices') ?>" class="nav-link <?= in_array($activeMenu, ['countries_prices']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('CountriesPricesLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
            </li>

            <?php if (in_array($activeMenu, ['settings', 'administrators', 'languages', 'menus', 'sitemap', 'redirects'])) $open = true;
            else $open = false; ?>
            <li class="nav-item <?= $open ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $open ? 'active' : '' ?>">
                <i class="nav-icon fa fa-cogs"></i>
                <p>
                  <?= lang('AdminPanel.settings') ?>
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <?php if (in_array('Settings', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/settings') ?>" class="nav-link <?= in_array($activeMenu, ['settings']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminSettingsLang.pageTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Admin', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/administrators') ?>" class="nav-link <?= in_array($activeMenu, ['administrators']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.administrators') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Languages', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/languages') ?>" class="nav-link <?= in_array($activeMenu, ['languages']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('AdminPanel.languages') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Redirects', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/redirects') ?>" class="nav-link <?= in_array($activeMenu, ['redirects']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('RedirectsLang.moduleTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <?php if (in_array('Sitemap', $configApp->loadedModules)) : ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= site_url($locale . '/admin/sitemap/robots') ?>" class="nav-link <?= in_array($activeMenu, ['sitemap']) ? 'active' : '' ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?= lang('SitemapLang.pageTitle') ?></p>
                    </a>
                  </li>
                </ul>
              <?php endif; ?>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= site_url($locale . '/admin/menus') ?>" class="nav-link <?= in_array($activeMenu, ['menus']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= lang('AdminPanel.menu') ?></p>
                  </a>
                </li>
              </ul>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <?php
    try {
      if (isset($are_you_sure)) {
        echo view($are_you_sure);
      }

      echo view($view);
    } catch (Exception $e) {
      echo "<pre><code>$e</code></pre>";
    }
    ?>

    <footer class="main-footer">
      <span>&copy; 2023</span>
      <div class="float-right d-none d-sm-inline-block">
        # eCMS / # eSHOP
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?= base_url('admin_panel/plugins/jquery/jquery.min.js') ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('admin_panel/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('admin_panel/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('admin_panel/plugins/chart.js/Chart.min.js') ?>"></script>
  <!-- Sparkline -->
  <script src="<?= base_url('admin_panel/plugins/sparklines/sparkline.js') ?>"></script>
  <!-- JQVMap -->
  <script src="<?= base_url('admin_panel/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
  <script src="<?= base_url('admin_panel/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?= base_url('admin_panel/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
  <!-- daterangepicker -->
  <script src="<?= base_url('admin_panel/plugins/moment/moment.min.js') ?>"></script>
  <script src="<?= base_url('admin_panel/plugins/daterangepicker/daterangepicker.js') ?>"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url('admin_panel/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('admin_panel/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('admin_panel/dist/js/adminlte.js') ?>"></script>
  <!-- ckeditor -->
  <script type="text/javascript" src="<?php echo base_url('admin_panel/plugins/ckeditor/ckeditor.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('admin_panel/plugins/ckeditor/ckfinder/ckfinder.js'); ?>"></script>

  <script src="<?= base_url('admin_panel/dist/js/validator.js') ?>"></script>
  <script src="<?= base_url('admin_panel/dist/js/main.js') ?>"></script>

  <script src="<?= base_url('admin_panel/plugins/select2/js/select2.min.js') ?>"></script>

  <?php
  if (isset($javascript)) {
    try {
      if (is_array($javascript)) {
        foreach ($javascript as $js) {
          echo view($js);
        }
      } else {
        echo view($javascript);
      }
    } catch (Exception $e) {
      echo "<pre><code>$e</code></pre>";
    }
  }
  ?>

  <script type="text/javascript">
    var editor_config = {
      filebrowserBrowseUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/ckfinder.html'); ?>',
      filebrowserImageBrowseUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/ckfinder.html?type=Images'); ?>',
      filebrowserUploadUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'); ?>',
      filebrowserImageUploadUrl: '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'); ?>',
      removePlugins: 'easyimage, cloudservices',
      cloudServices_tokenUrl: '<?php echo base_url(); ?>',
      cloudServices_uploadUrl: '<?php echo site_url('uploads/wysiwyg'); ?>',
      allowedContent: true,
      removeButtons: 'Flash,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Iframe,Language,NewPage,Templates,SelectAll,SpellChecker,Paste,PasteText'
    };

    $(".ckeditor").each(function(index, formtextarea) {
      if (formtextarea.id == '') {
        $(formtextarea).attr('id', 'myckeditorcustomid' + index);
      }

      // allow i tags to be empty (for font awesome)
      CKEDITOR.dtd.$removeEmpty['i'] = false;
      CKEDITOR.dtd.$removeEmpty['span'] = false;

      var editor = CKEDITOR.replace(formtextarea.id, editor_config);

      CKFinder.setupCKEditor(editor, '<?php echo site_url('admin_panel/plugins/ckeditor/ckfinder'); ?>');
    });

    $(function() {
      $('[data-tooltip="tooltip"]').tooltip()
    })
  </script>

</body>

</html>