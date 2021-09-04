<!-- <div class="modal fade" id="quickLogin" tabindex="-1" role="dialog">
   <div class="modal-dialog  modal-sm modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close custom_close_pp" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only"><?php echo e(t('Close')); ?></span>
            </button>
         </div>
         <form role="form" method="POST" action="<?php echo e(\App\Helpers\UrlGen::login()); ?>">
            <?php echo csrf_field(); ?>

            <div class="modal-body">

               <div class="main_dummy_image">
                  <img src="<?php echo e(asset('assets/img/dummy-image.jpg')); ?>" class="img-fluid" alt=""> 
                  <p>Save all your favorite items in one place</p>
               </div>

               <?php if(isset($errors) and $errors->any() and old('quickLoginForm')=='1'): ?>
               <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <ul class="list list-check"> 
                     <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <li><?php echo e($error); ?></li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
               </div>
               <?php endif; ?>
               <?php if(
               config('settings.social_auth.social_login_activation')
               and (
               (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
               or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
               or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
               or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
               )
               ): ?>
               <div class="row  pl-2 pr-2 social_logins">
                  <?php if(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret')): ?>
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-fb">
                        <a href="<?php echo e(url('auth/facebook')); ?>" class="btn-fb"
                           title="<?php echo strip_tags(t('Login with Facebook')); ?>">
                        <i class="icon-facebook-rect"></i> Continue with Facebook
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
                  <?php if(config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret')): ?>
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lkin">
                        <a href="<?php echo e(url('auth/linkedin')); ?>" class="btn-lkin"
                           title="<?php echo strip_tags(t('Login with LinkedIn')); ?>">
                        <i class="icon-linkedin"></i> Continue with LinkedIn
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
                  <?php if(config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret')): ?>
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-tw">
                        <a href="<?php echo e(url('auth/twitter')); ?>" class="btn-tw"
                           title="<?php echo strip_tags(t('Login with Twitter')); ?>">
                        <i class="icon-twitter-bird"></i> Continue with Twitter
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
                  <?php if(config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret')): ?>
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-danger">
                        <a href="<?php echo e(url('auth/google')); ?>" class="btn-danger"
                           title="<?php echo strip_tags(t('Login with Google')); ?>">
                        <i class="icon-googleplus-rect"></i> Continue with Google
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
                  <?php if(config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret')): ?>
                  <div class="main_btn_social mb-0 toggle_login_form">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-danger">
                        <a href="javascriptvoid:(0)" class="btn-danger"
                           title="<?php echo strip_tags(t('Login with Google')); ?>">
                        Continue with Email
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
               </div>
               <?php endif; ?>
               <div class="main_login_form">
                  <?php
                     $loginValue = (session()->has('login')) ? session('login') : old('login');
                     $loginField = getLoginField($loginValue);
                     if ($loginField == 'phone') {
                         $loginValue = phoneFormat($loginValue, old('country', config('country.code')));
                     }
                     ?>
                  <?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="icon-user fa"></i></span>
                        </div>
                        <input id="mLogin" name="login" type="text" placeholder="Login (Email or Phone)"
                           class="form-control<?php echo e($loginError); ?>" value="<?php echo e($loginValue); ?>">
                     </div>
                  </div>
                  <?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
                  <div class="form-group">
                     <label for="mPassword" class="control-label"><?php echo e(t('password')); ?></label>
                     <div class="input-group show-pwd-group">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="icon-lock fa"></i></span>
                        </div>
                        <input id="mPassword" name="password" type="password"
                           class="form-control<?php echo e($passwordError); ?>" placeholder="<?php echo e(t('password')); ?>"
                           autocomplete="off">
                        <span class="icon-append show-pwd">
                        <button type="button" class="eyeOfPwd">
                        <i class="far fa-eye-slash"></i>
                        </button>
                        </span>
                     </div>
                  </div>
                  <?php $rememberError = (isset($errors) and $errors->has('remember')) ? ' is-invalid' : ''; ?>
                  <div class="form-group">
                     <label class="checkbox form-check-label pull-left mt-2" style="font-weight: normal;">
                     <input type="checkbox" value="1" name="remember" id="mRemember"
                        class="<?php echo e($rememberError); ?>"> <?php echo e(t('keep_me_logged_in')); ?>

                     </label>
                     <p class="pull-right mt-2">
                        <a href="<?php echo e(url('password/reset')); ?>">
                        <?php echo e(t('lost_your_password')); ?>

                        </a> / <a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>">
                        <?php echo e(t('register')); ?>

                        </a>
                     </p>
                     <div style=" clear:both"></div>
                  </div>
                  <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['label' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <input type="hidden" name="quickLoginForm" value="1">
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-revert hide_main_form"><?php echo e(t('Cancel')); ?></button>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo e(t('log_in')); ?></button>
                </div>
               </div>
            </div>
      </form>
   </div>
</div>
</div>


<script>

$(document).ready(function(){
    $('.toggle_login_form').click(function(){
       $('.main_login_form').show(500);
       $('.social_logins').hide(500); 
    });
    $('.hide_main_form').click(function(){
        $('.main_login_form').hide(500);
         $('.social_logins').show(500);
    });
});

</script> --><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/locations.blade.php ENDPATH**/ ?>