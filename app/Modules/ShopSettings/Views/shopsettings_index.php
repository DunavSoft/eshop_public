<?= form_open($locale . '/admin/shopsettings', 'id="form"') ?>
<!-- Content Wrapper. Contains category content -->
<div class="content-wrapper">
	<!-- Content Header (Category header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?= $pageTitle ?></h1>
				</div>
				<div class="col-sm-6">
					<div class="btn-group float-right">
						<input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?php echo lang('AdminPanel.saveReturn'); ?>" />
					</div>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<?= \Config\Services::validation()->listErrors(); ?>

	<?php if (!empty($errors)) : ?>
		<div class="content">
			<div class="alert alert-danger">
				<?php foreach ($errors as $field => $e) : ?>
					<p><?= $e ?></p>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>

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

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">

			<!-- /.card -->
			<div class="card card-primary card-outline">
				<div class="card-body">

					<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
						<?php $i = 0;
						foreach ($languages as $language) : $i++; ?>
							<li class="nav-item">
								<a class="nav-link <?php if ($i == 1) : ?>active<?php endif; ?>" id="custom-content-below-content-tab<?php echo $language->uri ?>" data-toggle="pill" href="#custom-content-below-content<?php echo $language->uri ?>" role="tab" aria-controls="custom-content-below-content<?php echo $language->uri ?>" <?php if ($i == 1) : ?>aria-selected="true" <?php endif; ?>><?php echo $language->native_name ?></a>
							</li>
						<?php endforeach; ?>

						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-info-tab" data-toggle="pill" href="#custom-content-below-info" role="tab" aria-controls="custom-content-below-seo" aria-selected="false"><?php echo lang('AdminPanel.info'); ?></a>
						</li>
					</ul>

					<div class="tab-content" id="custom-content-below-tabContent">


						<?php $i = 0;
						foreach ($languages as $language) : $i++; ?>
							<div class="tab-pane fade <?php if ($i == 1) : ?>show active<?php endif; ?>" id="custom-content-below-content<?php echo $language->uri; ?>" role="tabpanel" aria-labelledby="custom-content-below-content-tab<?php echo $language->uri; ?>">

								<span class="form-horizontal">
									<div class="card-body">

										<ul class="nav nav-tabs" id="shopsettings__group-tab" role="tablist">

											<?php
											$shopsettingsGroupIndex = 0;

											foreach ($shopsettingsFile as $key => $shopsettingsArray) :
												$shopsettingsGroupIndex++;
												$shopsettingsGroupTitleMap = [
													'generalShopSettings' =>  lang('ShopSettingsLang.generalShopSettings'),
													'campaignShopSettings' => lang('ShopSettingsLang.campaignShopSettings'),
													'cartShopSettings' => lang('ShopSettingsLang.cartShopSettings'),
													'checkoutSettings' => lang('ShopSettingsLang.checkoutSettings'),
													'socialMediaShopSettings' => lang('ShopSettingsLang.socialMediaShopSettings'),
													'emailsShopSettings' => lang('ShopSettingsLang.emailsShopSettings'),
													'subscriptionsSettings' => lang('ShopSettingsLang.subscriptionsSettings'),
													'statusesSettings' => lang('ShopSettingsLang.statusesSettings'),
													'speedySettings' => lang('ShopSettingsLang.speedySettings'),
													'feedSettings' => lang('ShopSettingsLang.feedSettings'),
												];

												$shopsettingsGroupTitle = $shopsettingsGroupTitleMap[$key];
											?>

												<?php if (($key == "speedySettings" && $shippingConfig->isSpeedy == true) || $key != "speedySettings") : ?>
													<li class="nav-item">
														<a class="nav-link <?php if ($shopsettingsGroupIndex == 1) : ?>active<?php endif; ?>" id="shopsettings__group__<?= $key . $language->uri ?>-tab" data-toggle="pill" href="#shopsettings__group__<?= $key . $language->uri ?>" role="tab" aria-controls="shopsettings__group__<?= $key . $language->uri ?>" aria-selected="false">
															<?php echo $shopsettingsGroupTitle; ?>
														</a>
													</li>
												<?php endif ?>
											<?php
											endforeach;
											?>
										</ul>

										<div class="tab-content" id="shopsettings__group-<?= $key . $language->uri ?>">
											<?php
											$shopsettingsGroupIndex = 0;



											foreach ($shopsettingsFile as $key => $shopsettingsArray) :
												$shopsettingsGroupIndex++;
											?>

												<div class="tab-pane fade <?php if ($shopsettingsGroupIndex == 1) : ?>show active<?php endif; ?>" id="shopsettings__group__<?= $key . $language->uri ?>" role="tabpanel" aria-labelledby="shopsettings__group__<?= $key . $language->uri ?>-tab">
													<span class="form-horizontal">
														<div class="card-body">
															<?php
															
															foreach ($shopsettingsArray as  &$shopsettingsFileElement) {
															
																$title = $shopsettingsFileElement[1];
															
																$shopsettingsFileElement[2] =  lang('ShopSettingsLang.' . $title);
															}
															unset($shopsettingsFileElement);
															?>
															<?php
															foreach ($shopsettingsArray as $shopsettingsFileElement) :
																echo view('\App\Modules\ShopSettings\Views\shopsettings_group', [
																	'shopsettingsFileElement' => $shopsettingsFileElement,
																	'language' => $language
																]);
															endforeach;
															?>
															<?php if ($key == 'feedSettings') : ?>
																<div class="form-group row">
																	<label for="" class="col-sm-2 text-start text-sm-right">Facebook feed url:</label>

																	<div class="col-sm-10">
																		<?= site_url($language->uri . '/feed/facebook') ?>
																	</div>
																</div>
																<div class="form-group row">
																	<label for="" class="col-sm-2 text-start text-sm-right">Google ads feed url:</label>

																	<div class="col-sm-10">
																		<?= site_url($language->uri . '/feed/google_ads') ?>
																	</div>
																</div>
															<?php endif ?>
														</div>
													</span>
												</div>


											<?php endforeach; ?>
										</div>
									</div>
								</span>
							</div>
						<?php endforeach; ?>

						<div class="tab-pane fade" id="custom-content-below-info" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
							<span class="form-horizontal">
								<div class="card-body">
									<div class="form-group row">
										<label for="updated_at" class="col-sm-2 text-start text-sm-right"><?= lang('AdminPanel.updatedAt') ?></label>
										<div class="col-sm-10">
											<?php echo date('d.m.Y H:i', $updated_at->updated_at); ?>
										</div>
									</div>
								</div>
							</span>
						</div>

						<div class="row mt-0 mb-2">
							<div class="col-sm-12 text-center">
								<div class="btn-group">
									<input class="btn btn-secondary" name="submit_save_and_return" type="submit" value="<?= lang('AdminPanel.saveReturn') ?>" />
								</div>
							</div>
						</div>

					</div>
				</div>
				<!-- /.card -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.container-fluid -->
	</section>
</div>
<!-- /.content-wrapper -->

<?= form_close() ?>