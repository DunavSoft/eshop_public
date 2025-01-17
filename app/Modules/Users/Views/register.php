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

      <div class="col-xl-4 col-right">
        <h2 style="font-family: 'Merriweather', 'sans-serif';"> <?= lang('AccountLang.account') ?> </h2>
        <div class="go-to-reg-div">
          <a href="<?php echo base_url('users/login'); ?>" class="go-to-reg"><i class="fa fa-sign-in"></i> <?= lang('AccountLang.login') ?> </a>
        </div>
      </div>
      <div class="col-xl-8 col-bordered">
        <h2 style="font-family: 'Merriweather', 'sans-serif';"><?= lang('AccountLang.createAccount') ?></h2>
        <!--Form-->
          <br>
        <?= form_open($locale . '/users/register', 'method="post" class="needs-validation" id="registerForm"') ?>
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
                    'value' => set_value('firstname', $firstname ?? ''),
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
                    'value' => set_value('lastname', $lastname ?? ''),
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
                    'required' => true,
                    'value' => set_value('email', $email ?? ''),
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.email')
                  ];

                  echo form_input($data);
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
                    'value' => set_value('phoneNumber', $phoneNumber ?? ''),
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
                    'required' => true,
                    'value' => set_value('city', $city ?? ''),
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
                  <label for="pass"><?= lang('AccountLang.password') ?> *</label>

                  <?php
                  $data = [
                    'type' => 'password',
                    'id' => 'password',
                    'name' => 'password',
                    'autocomplete' => 'on',
                    'required' => true,
                    'class' => 'form-control home-form',
                    'placeholder' => lang('AccountLang.password')
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
            </div>
          </div>

          <button class="btn btn-request btn-home-subbmit" type="submit">
            <?= lang('AccountLang.registerMe') ?>
          </button>
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</section>
