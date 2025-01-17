  <!-- Content Wrapper. Contains propertiesCategories content -->
  <div class="content-wrapper">
  
	  <div id="success" class="m-3 alert alert-success alert-dismissible fade show d-none" role="alert">
		<span id="success-message"></span>
		<button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  
	  <div id="error" class="m-3 alert alert-danger fade show d-none" role="alert">
		<span id="error-message"></span>
	  </div>
	
    <!-- Content Header -->
    <section class="content-header pb-0">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 col-xs-12">
            <h1><?= lang('PropertiesCategoriesLang.moduleTitle') ?><?= ($deleted == 'deleted' ? lang('AdminPanel.whichDeleted') : '') ?></h1>
          </div>
          <div class="col-sm-6 col-xs-12">
			<div class="float-right btn-group">
			<?php if ($deleted == 'deleted'):?>
			  <a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/properties_categories');?>">
				<i class="fas fa-list" data-tooltip="tooltip" title="<?= lang('PropertiesCategoriesLang.backToList') ?>"></i>
			  </a>
			<?php else: ?>
			   <a class="btn btn-secondary btn-sm" href="<?= site_url($locale . '/admin/properties_categories/deleted') ?>">
				<i class="fas fa-trash" data-tooltip="tooltip" title="<?= lang('PropertiesCategoriesLang.moduleTitle') ?><?= lang('AdminPanel.whichDeleted') ?>"></i>
			  </a>
			<?php endif; ?>
			  <a class="btn btn-primary btn-sm float-right edit-button" href="<?= site_url($locale . '/admin/properties_categories/form') ?>" data-id="new" data-toggle="modal" data-target="#ModalFormSecondary">
			    <i class="fas fa-plus"></i> <?= lang('PropertiesCategoriesLang.add') ?>
			  </a>
			</div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<?php if (!empty($message)): ?>
		<div class="content">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?php echo $message; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if (! empty($error)): ?>
		<div class="content">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo $error;?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif ?>
	
	<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-primary card-outline">
        
        <div class="card-body p-0 table-responsive" id="ajax-content">
          <?php
			if (isset($ajax_view)) {
				try
				{
					if (is_array($ajax_view)) {
						foreach ($ajax_view as $v) {
							echo view($v);
						}
					} else {
						echo view($ajax_view);
					}
				}
				catch (Exception $e)
				{
					echo "<pre><code>$e</code></pre>";
				}
			}
		  ?>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
	
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->