<section class="request page-details" id="request">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php if (session()->has('errors')) : ?>
          <div class="content">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= \Config\Services::validation()->listErrors(); ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($errors)) : ?>
          <div class="content">
            <div class="alert alert-danger">
              <?php foreach ($errors as $field => $e) : ?>
                <p><?= $e ?></p>
              <?php endforeach ?>
            </div>
          </div>
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
          <div class="content">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= session('error') ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        <?php endif; ?>

        <?php if (session()->has('message')) : ?>
          <div class="content">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= session('message') ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-12 col-bordered">
        <div class="d-flex align-items-center mb-5">
          <h3 class="m-0"><i class="fa fa-chevron-right"></i><?= lang('AccountLang.myAccount') ?></h3>
          <h2 class="mx-4 mb-0"><?php echo $customer->firstname . ' ' . $customer->lastname; ?></h2>
        </div>

        <?= form_open($locale . '/users/account/edit', 'method="post" class="needs-validation" id="editAccountForm"') ?>
          <div class="row g-4">
            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="name"><?= lang('AccountLang.firstname') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'text',
                    'id' => 'firstname',
                    'name' => 'firstname',
                    'required' => true,
                    'value' => set_value('firstname', $customer->firstname ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.firstname')
                  ];

                  echo form_input($data);
                  ?>
                </div>
                <div class="col-md-6">
                  <label for="lastname"><?= lang('AccountLang.lastname') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'text',
                    'id' => 'lastname',
                    'name' => 'lastname',
                    'required' => true,
                    'value' => set_value('lastname', $customer->lastname ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.lastname')
                  ];

                  echo form_input($data);
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="email"><?= lang('AccountLang.email') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'email',
                    'id' => 'email',
                    'name' => 'email',
                    'disabled' => true,
                    'value' => set_value('email', $customer->email ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.email')
                  ];

                  echo form_input($data);
                  echo form_hidden('email', set_value('email', $customer->email ?? ''));
                  ?>
                </div>
                <div class="col-md-6">
                  <label for="phone"><?= lang('AccountLang.phoneNumber') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'tel',
                    'id' => 'phoneNumber',
                    'name' => 'phoneNumber',
                    'required' => true,
                    'value' => set_value('phoneNumber', $customer->phone_number ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.phoneNumber')
                  ];

                  echo form_input($data);
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-12">
                  <label for="city"><?= lang('AccountLang.city') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'text',
                    'id' => 'city',
                    'name' => 'city',
                    'value' => set_value('city', $customer->city ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.city')
                  ];

                  echo form_input($data);
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row ">
                <div class="col-md-6">
                  <label for="pass"><?= lang('AccountLang.newPassword') ?></label>

                  <?php
                  $data = [
                    'type' => 'password',
                    'id' => 'password',
                    'name' => 'password',
                    'autocomplete' => 'on',
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.newPassword')
                  ];

                  echo form_input($data);
                  ?>
                </div>
                <div class="col-md-6">
                  <label for="passconf"><?= lang('AccountLang.confirmPassword') ?></label>

                  <?php
                  $data = [
                    'type' => 'password',
                    'id' => 'confirmPassword',
                    'name' => 'confirmPassword',
                    'autocomplete' => 'on',
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.confirmPassword')
                  ];

                  echo form_input($data);
                  ?>
                </div>
              </div>
            </div>
          </div>

          <button class="btn btn-request btn-home-subbmit" type="submit">
            Запазване
          </button>
        <?php echo form_close() ?>
      </div>
<?php /*
      <?php echo form_open($locale . '/users/password/change', 'method="post" class="needs-validation" id="passwordChangeForm"')?>
        <div class="col-12 my-5 col-bordered">
          <h3 class="mb-4">Смяна на парола</h3>

          <?php echo form_hidden('email', set_value('email', $customer->email ?? '')); ?>

          <div class="row g-4">
            <div class="col-12">
              <label for="pass"><?= lang('AccountLang.oldPassword') ?> *</label>

              <?php
              $data = [
                'type' => 'password',
                'id' => 'oldPassword',
                'name' => 'oldPassword',
                'autocomplete' => 'on',
                'required' => true,
                'class' => 'form-control home-form',
                'placeholder' => lang('AccountLang.oldPassword')
              ];

              echo form_input($data);
              ?>
            </div>

            <div class="col-md-6">
              <label for="pass"><?= lang('AccountLang.newPassword') ?> *</label>

              <?php
              $data = [
                'type' => 'password',
                'id' => 'newPassword',
                'name' => 'newPassword',
                'autocomplete' => 'on',
                'required' => true,
                'class' => 'form-control home-form',
                'placeholder' => lang('AccountLang.newPassword')
              ];

              echo form_input($data);
              ?>
            </div>
            <div class="col-md-6">
              <label for="passconf"><?= lang('AccountLang.confirmPassword') ?> *</label>

              <?php
              $data = [
                'type' => 'password',
                'id' => 'confirmPassword',
                'name' => 'confirmPassword',
                'autocomplete' => 'on',
                'required' => true,
                'class' => 'form-control home-form',
                'placeholder' => lang('AccountLang.confirmPassword')
              ];

              echo form_input($data);
              ?>
            </div>
          </div>

          <button class="btn btn-request btn-home-subbmit" type="submit">
            Запазване
          </button>
        <?php echo form_close() ?>
      </div>
	  */?>
    </div>
  </div>
</section>


<?php include('orders_history.php') ?>
