


<?php $__env->startSection('content'); ?>
	<?php if(!(isset($paddingTopExists) and $paddingTopExists)): ?>
		<div class="h-spacer"></div>
	<?php endif; ?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<?php if(isset($errors) and $errors->any()): ?>
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong><?php echo e(t('oops_an_error_has_occurred')); ?></strong></h5>
							<ul class="list list-check">
								<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<?php if(Session::has('flash_notification')): ?>
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="col-md-8 page-content">
					<div class="inner-box">
						<h2 class="title-2">
							<strong><i class="icon-user-add"></i> Create Your Account</strong>
						</h2>
						
						<?php if(
							config('settings.social_auth.social_login_activation')
							and (
								(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
								or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
								or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
								or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
								)
							): ?>
							<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
								<?php if(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret')): ?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
										<a href="<?php echo e(url('auth/facebook')); ?>" class="btn-fb"><i class="icon-facebook-rect"></i> <?php echo t('Login with Facebook'); ?></a>
									</div>
								</div>
								<?php endif; ?>
								<?php if(config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret')): ?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-lkin">
										<a href="<?php echo e(url('auth/linkedin')); ?>" class="btn-lkin"><i class="icon-linkedin"></i> <?php echo t('Login with LinkedIn'); ?></a>
									</div>
								</div>
								<?php endif; ?>
								<?php if(config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret')): ?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-tw">
										<a href="<?php echo e(url('auth/twitter')); ?>" class="btn-tw"><i class="icon-twitter-bird"></i> <?php echo t('Login with Twitter'); ?></a>
									</div>
								</div>
								<?php endif; ?>
								<?php if(config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret')): ?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
										<a href="<?php echo e(url('auth/google')); ?>" class="btn-danger"><i class="icon-googleplus-rect"></i> <?php echo t('Login with Google'); ?></a>
									</div>
								</div>
								<?php endif; ?>
							</div>
							
							<div class="row d-flex justify-content-center loginOr">
								<div class="col-xl-12 mb-1">
									<hr class="hrOr">
									<span class="spanOr rounded"><?php echo e(t('or')); ?></span>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="row mt-5">
							<div class="col-xl-12">
								<form id="signupForm" class="form-horizontal" method="POST" action="<?php echo e(url()->current()); ?>">
									<?php echo csrf_field(); ?>

									<fieldset>

										<!-- name -->
										<?php $nameError = (isset($errors) and $errors->has('name')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label"><?php echo e(t('Name')); ?> <sup>*</sup></label>
											<div class="col-md-6">
												<input name="name" placeholder="<?php echo e(t('Name')); ?>" class="form-control input-md<?php echo e($nameError); ?>" type="text" value="<?php echo e(old('name')); ?>">
											</div>
										</div>

										<!-- country_code -->
										<?php if(empty(config('country.code'))): ?>
											<?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label<?php echo e($countryCodeError); ?>" for="country_code"><?php echo e(t('your_country')); ?> <sup>*</sup></label>
												<div class="col-md-6">
													<select id="countryCode" name="country_code" class="form-control sselecter<?php echo e($countryCodeError); ?>">
														<option value="0" <?php echo e((!old('country_code') or old('country_code')==0) ? 'selected="selected"' : ''); ?>><?php echo e(t('Select')); ?></option>
														<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($code); ?>" <?php echo e((old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$code) ? 'selected="selected"' : ''); ?>>
																<?php echo e($item->get('name')); ?>

															</option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
											</div>
										<?php else: ?>
											<input id="countryCode" name="country_code" type="hidden" value="<?php echo e(config('country.code')); ?>">
										<?php endif; ?>

										<?php if(isEnabledField('phone')): ?>
											<!-- phone -->
											<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label"><?php echo e(t('phone')); ?>

													<?php if(!isEnabledField('email')): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span id="phoneCountry" class="input-group-text"><?php echo getPhoneIcon(old('country', config('country.code'))); ?></span>
														</div>
														
														<input name="phone"
															   placeholder="<?php echo e((!isEnabledField('email')) ? t('Mobile Phone Number') : t('phone_number')); ?>"
															   class="form-control input-md<?php echo e($phoneError); ?>"
															   type="text"
															   value="<?php echo e(phoneFormat(old('phone'), old('country', config('country.code')))); ?>"
														>
														
														<div class="input-group-append tooltipHere" data-placement="top"
															 data-toggle="tooltip"
															 data-original-title="<?php echo e(t('Hide the phone number on the ads')); ?>">
															<span class="input-group-text">
																<input name="phone_hidden" id="phoneHidden" type="checkbox"
																	   value="1" <?php echo e((old('phone_hidden')=='1') ? 'checked="checked"' : ''); ?>>&nbsp;<small><?php echo e(t('Hide')); ?></small>
															</span>
														</div>
													</div>
												</div>
											</div>
										<?php endif; ?>
									
										<?php if(isEnabledField('email')): ?>
											<!-- email -->
											<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email"><?php echo e(t('email')); ?>

													<?php if(!isEnabledField('phone')): ?>
														<sup>*</sup>
													<?php endif; ?>
												</label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="icon-mail"></i></span>
														</div>
														<input id="email"
															   name="email"
															   type="email"
															   class="form-control<?php echo e($emailError); ?>"
															   placeholder="<?php echo e(t('email')); ?>"
															   value="<?php echo e(old('email')); ?>"
														>
													</div>
												</div>
											</div>
										<?php endif; ?>
									
										<?php if(isEnabledField('username')): ?>
											<!-- username -->
											<?php $usernameError = (isset($errors) and $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email"><?php echo e(t('Username')); ?></label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="icon-user"></i></span>
														</div>
														<input id="username"
															   name="username"
															   type="text"
															   class="form-control<?php echo e($usernameError); ?>"
															   placeholder="<?php echo e(t('Username')); ?>"
															   value="<?php echo e(old('username')); ?>"
														>
													</div>
												</div>
											</div>
										<?php endif; ?>
										
										<!-- password -->
										<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label" for="password"><?php echo e(t('password')); ?> <sup>*</sup></label>
											<div class="col-md-6">
												<div class="input-group show-pwd-group">
													<input id="password" name="password" type="password" class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('password')); ?>" autocomplete="off">
													<span class="icon-append show-pwd">
														<button type="button" class="eyeOfPwd">
															<i class="far fa-eye-slash"></i>
														</button>
													</span>
												</div>
												<br>
												<input id="password_confirmation" name="password_confirmation" type="password" class="form-control<?php echo e($passwordError); ?>"
													   placeholder="<?php echo e(t('Password Confirmation')); ?>" autocomplete="off">
												<small id="" class="form-text text-muted">
													<?php echo e(t('at_least_num_characters', ['num' => config('larapen.core.passwordLength.min', 6)])); ?>

												</small>
											</div>
										</div>
										
										<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['colLeft' => 'col-md-4', 'colRight' => 'col-md-6'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										
										<!-- accept_terms -->
										<?php $acceptTermsError = (isset($errors) and $errors->has('accept_terms')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-6">
												<div class="form-check">
													<input name="accept_terms" id="acceptTerms"
														   class="form-check-input<?php echo e($acceptTermsError); ?>"
														   value="1"
														   type="checkbox" <?php echo e((old('accept_terms')=='1') ? 'checked="checked"' : ''); ?>

													>
													
													<label class="form-check-label" for="acceptTerms" style="font-weight: normal;">
														<?php echo t('accept_terms_label', ['attributes' => getUrlPageByType('terms')]); ?>

													</label>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>
										
										<!-- accept_marketing_offers -->
										<?php $acceptMarketingOffersError = (isset($errors) and $errors->has('accept_marketing_offers')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-6">
												<div class="form-check">
													<input name="accept_marketing_offers" id="acceptMarketingOffers"
														   class="form-check-input<?php echo e($acceptMarketingOffersError); ?>"
														   value="1"
														   type="checkbox" <?php echo e((old('accept_marketing_offers')=='1') ? 'checked="checked"' : ''); ?>

													>
													
													<label class="form-check-label" for="acceptMarketingOffers" style="font-weight: normal;">
														<?php echo t('accept_marketing_offers_label'); ?>

													</label>
												</div>
												<div style="clear:both"></div>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-6">
												<button id="signupBtn" class="btn btn-success btn-lg"> <?php echo e(t('register')); ?> </button>
											</div>
										</div>

										<div class="mb-5"></div>

									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class="icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>Post a free Ad</strong></h3>
							<p>
								<?php echo e(t('do_you_have_something_text',
								['appName' => config('app.name')])); ?>

							</p>
						</div>
						<div class="promo-text-box"><i class=" icon-pencil-circled fa fa-4x icon-color-2"></i>
							<h3><strong><?php echo e(t('create_and_manage_items')); ?></strong></h3>
							<p><?php echo e(t('become_a_best_seller_or_buyer_text')); ?></p>
						</div>
						<div class="promo-text-box"><i class="icon-heart-2 fa fa-4x icon-color-3"></i>
							<h3><strong><?php echo e(t('create_your_favorite_ads_list')); ?></strong></h3>
							<p><?php echo e(t('create_your_favorite_ads_list_text')); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
	<script>
		$(document).ready(function () {
			/* Submit Form */
			$("#signupBtn").click(function () {
				$("#signupForm").submit();
				return false;
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/auth/register/index.blade.php ENDPATH**/ ?>