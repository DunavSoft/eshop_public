<section class="request page-details" id="request">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1><?php echo lang('SubscriptionsLang.unsubscriptionTitle'); ?></h1>
				
				<?php if (!empty($message)): ?>
					<div class="content">
							<div class="alert alert-success alert-dismissible fade show" role="alert">
									<?php echo $message; ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
					</div>
				<?php endif; ?>

				<?php if (!empty($error)): ?>
					<div class="content">
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo $error; ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
					</div>
				<?php endif; ?>
	
      </div>
    </div>
  </div>
</section>
