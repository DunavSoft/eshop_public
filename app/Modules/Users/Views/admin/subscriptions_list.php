<div class="content-wrapper">
  <!-- Content Header (Category header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-12">
          <h1><?= lang('SubscriptionsLang.pageTitle') ?></h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <?php if (!empty($message)) : ?>
    <div class="content">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  <?php endif; ?>

  <?php if (!empty($error)) : ?>
    <div class="content">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  <?php endif ?>

  <section class="content">
    <div class="card card-primary card-outline">
      <div class="card-body p-0" id="ajax-content">
        <?php include('subscriptions_list_ajax.php') ?>
      </div>
    </div>
  </section>
</div>
