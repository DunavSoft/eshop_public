<?=form_open($locale . '/admin/administrators/form/' . $id, 'id="form"')?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <a href="<?=site_url($locale . '/admin/administrators')?>" data-tooltip="tooltip" title="<?=lang('AdminPanel.back')?>"><i class="fa fa-arrow-left"></i></a> <?= $pageTitle ?>
            </h1>
          </div>
		  <div class="col-sm-6">
		    <div class="btn-group float-right">
			  <input class="btn btn-primary" name="submit" type="submit" value="<?=lang('AdminPanel.save')?>" />
			  <input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?=lang('AdminPanel.saveReturn')?>" />
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<?= \Config\Services::validation()->listErrors(); ?>
	
	<?php if (! empty($errors)) : ?>
		<div class="content">
			<div class="alert alert-danger">
			<?php foreach ($errors as $field => $e) : ?>
				<p><?= $e ?></p>
			<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>
	
	<?php if (session()->has('message')): ?>
		<div class="content">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?= session('message') ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endif; ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  
	   <!-- /.card -->
        <div class="card card-primary card-outline">
          <div class="card-body pb-0">
            
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              
			  <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-content-tab" data-toggle="pill" href="#custom-content-below-content" role="tab" aria-controls="custom-content-below-content" aria-selected="true"><?=lang('AdminPanel.common')?></a>
              </li>

			  <?php if ($id != 'new'):?>
			  <li class="nav-item">
                <a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info');?></a>
              </li>
			   <?php endif;?>
			   
            </ul>
			
            <div class="tab-content" id="custom-content-below-tabContent">
			  <div class="tab-pane fade show active" id="custom-content-below-content" role="tabpanel" aria-labelledby="custom-content-below-content-tab">
				<span class="form-horizontal">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="firstname" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.firstName')?> * </label>
                      <div class="col-sm-10">
						<?php
						$data = [ 'id' => 'firstname', 'name' => 'save[firstname]', 'value' => set_value('firstname', $firstname), 'class' => 'form-control', 'placeholder' => 'First name', 'required' => 'required' ];
						echo form_input($data);
						?>
                      </div>
                    </div>
					<div class="form-group row">
                      <label for="lastname" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.lastName')?></label>
                      <div class="col-sm-10">
						<?php
						$data = [ 'id' => 'lastname', 'name' => 'save[lastname]', 'value' => set_value('lastname', $lastname), 'class' => 'form-control', 'placeholder' => 'Last name' ];
						echo form_input($data);
						?>
                      </div>
                    </div>
					<div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.email')?> *</label>
                      <div class="col-sm-10">
						<?php
						if ($id != 'new' && $duplicate != 1) {
							$data = [ 'readonly' => 'readonly', 'id' => 'email', 'name' => 'save[email]', 'value' => set_value('email', $email), 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required' ];
						} else {
							$data = [ 'id' => 'email', 'name' => 'save[email]', 'value' => set_value('email', $email), 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required' ];
						}
						
						echo form_input($data);
						?>
                      </div>
                    </div>
					
					<div class="form-group row">
                      <label for="language" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.language')?> *</label>
                      <div class="col-sm-10">
                        <?php
						echo form_dropdown('save[language]', $languagesArray, set_value('save[language]', $language), 'class="form-control"');
						?>
                      </div>
                    </div>
					
					
					<div class="form-group row">
                      <label for="access" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.access')?> *</label>
                      <div class="col-sm-10">
                        <?php
						echo form_dropdown('save[access]', $adminAccessOption, set_value('save[access]', $access), 'class="form-control"');
						?>
                      </div>
                    </div>
					<div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.password')?></label>
                      <div class="col-sm-10">
						<?php
						$data = [ 'id' => 'password', 'name' => 'save[password]', 'value' => '', 'class' => 'form-control' ];
						echo form_password($data);
						?>
                      </div>
                    </div>
					<div class="form-group row">
                      <label for="confirm" class="col-sm-2 col-form-label text-start text-sm-right"><?=lang('AdminPanel.repeatPassword')?></label>
                      <div class="col-sm-10">
						<?php
						$data = [ 'id' => 'confirm', 'name' => 'save[confirm]', 'value' => '', 'class' => 'form-control' ];
						echo form_password($data);
						?>
                      </div>
                    </div>
                  </div>
                </span>
              </div>
			  
			  <div class="tab-pane fade" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
                <span class="form-horizontal">
				  <div class="card-body">
				    <div class="form-group row">
					  <label for="created_at" class="col-sm-2 text-start text-sm-right"><?=lang('AdminPanel.createdAt')?></label>
					  <div class="col-sm-10">
						<?php echo date('d.m.Y H:i', $created_at); ?>
					  </div>
				    </div>
					<div class="form-group row">
					  <label for="updated_at" class="col-sm-2 text-start text-sm-right"><?=lang('AdminPanel.updatedAt')?></label>
					  <div class="col-sm-10">
						<?php echo date('d.m.Y H:i', $updated_at); ?>
					  </div>
				    </div>
				  </div>
			    </span>
              </div>
            </div>
			
			  <div class="row mt-0 mb-2">
			    <div class="col-sm-12 text-center">
				  <div class="btn-group">
				    <input class="btn btn-primary" name="submit" type="submit" value="<?=lang('AdminPanel.save')?>" />
				    <input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?=lang('AdminPanel.saveReturn')?>" />
				  </div>
			    </div>
			  </div>
			  
			<!-- /.tab-content -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
		</div>
      <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->
  
<?=form_close()?>