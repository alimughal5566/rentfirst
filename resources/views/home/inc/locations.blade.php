<!-- <div class="modal fade" id="quickLogin" tabindex="-1" role="dialog">
   <div class="modal-dialog  modal-sm modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close custom_close_pp" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">{{ t('Close') }}</span>
            </button>
         </div>
         <form role="form" method="POST" action="{{ \App\Helpers\UrlGen::login() }}">
            {!! csrf_field() !!}
            <div class="modal-body">

               <div class="main_dummy_image">
                  <img src="{{asset('assets/img/dummy-image.jpg')}}" class="img-fluid" alt=""> 
                  <p>Save all your favorite items in one place</p>
               </div>

               @if (isset($errors) and $errors->any() and old('quickLoginForm')=='1')
               <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <ul class="list list-check"> 
                     @foreach($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               @if (
               config('settings.social_auth.social_login_activation')
               and (
               (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
               or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
               or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
               or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
               )
               )
               <div class="row  pl-2 pr-2 social_logins">
                  @if (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-fb">
                        <a href="{{ url('auth/facebook') }}" class="btn-fb"
                           title="{!! strip_tags(t('Login with Facebook')) !!}">
                        <i class="icon-facebook-rect"></i> Continue with Facebook
                        </a>
                     </div>
                  </div>
                  @endif
                  @if (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lkin">
                        <a href="{{ url('auth/linkedin') }}" class="btn-lkin"
                           title="{!! strip_tags(t('Login with LinkedIn')) !!}">
                        <i class="icon-linkedin"></i> Continue with LinkedIn
                        </a>
                     </div>
                  </div>
                  @endif
                  @if (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-tw">
                        <a href="{{ url('auth/twitter') }}" class="btn-tw"
                           title="{!! strip_tags(t('Login with Twitter')) !!}">
                        <i class="icon-twitter-bird"></i> Continue with Twitter
                        </a>
                     </div>
                  </div>
                  @endif
                  @if (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
                  <div class="main_btn_social">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-danger">
                        <a href="{{ url('auth/google') }}" class="btn-danger"
                           title="{!! strip_tags(t('Login with Google')) !!}">
                        <i class="icon-googleplus-rect"></i> Continue with Google
                        </a>
                     </div>
                  </div>
                  @endif
                  @if (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
                  <div class="main_btn_social mb-0 toggle_login_form">
                     <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-danger">
                        <a href="javascriptvoid:(0)" class="btn-danger"
                           title="{!! strip_tags(t('Login with Google')) !!}">
                        Continue with Email
                        </a>
                     </div>
                  </div>
                  @endif
               </div>
               @endif
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
                           class="form-control{{ $loginError }}" value="{{ $loginValue }}">
                     </div>
                  </div>
                  <?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
                  <div class="form-group">
                     <label for="mPassword" class="control-label">{{ t('password') }}</label>
                     <div class="input-group show-pwd-group">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="icon-lock fa"></i></span>
                        </div>
                        <input id="mPassword" name="password" type="password"
                           class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}"
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
                        class="{{ $rememberError }}"> {{ t('keep_me_logged_in') }}
                     </label>
                     <p class="pull-right mt-2">
                        <a href="{{ url('password/reset') }}">
                        {{ t('lost_your_password') }}
                        </a> / <a href="{{ \App\Helpers\UrlGen::register() }}">
                        {{ t('register') }}
                        </a>
                     </p>
                     <div style=" clear:both"></div>
                  </div>
                  @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.recaptcha', 'layouts.inc.tools.recaptcha'], ['label' => true])
                  <input type="hidden" name="quickLoginForm" value="1">
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-revert hide_main_form">{{ t('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary pull-right">{{ t('log_in') }}</button>
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

</script> -->