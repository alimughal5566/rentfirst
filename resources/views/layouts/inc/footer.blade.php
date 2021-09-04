<?php
if (
    config('settings.other.ios_app_url') ||
    config('settings.other.android_app_url') ||
    config('settings.social_link.facebook_page_url') ||
    config('settings.social_link.twitter_url') ||
    config('settings.social_link.google_plus_url') ||
    config('settings.social_link.linkedin_url') ||
    config('settings.social_link.pinterest_url') ||
    config('settings.social_link.instagram_url')
) {
    $colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
    $colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
    $colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
    $colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
} else {
    $colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
    $colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
    $colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
    $colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
}
?>
{{--<div class="container">--}}
{{--    <div class="row">--}}

{{--        @if (!config('settings.footer.hide_links'))--}}
{{--            <div class="{{ $colClass1 }}">--}}
{{--                <div class="footer-col">--}}
{{--                    <h4 class="footer-title">{{ t('about_us') }}</h4>--}}
{{--                    <ul class="list-unstyled footer-nav">--}}
{{--                        @if (isset($pages) and $pages->count() > 0)--}}
{{--                            @foreach($pages as $page)--}}
{{--                                <li>--}}
{{--                                    <?php--}}
{{--                                    $linkTarget = '';--}}
{{--                                    if ($page->target_blank == 1) {--}}
{{--                                        $linkTarget = 'target="_blank"';--}}
{{--                                    }--}}
{{--                                    ?>--}}
{{--                                    @if (!empty($page->external_link))--}}
{{--                                        <a href="{!! $page->external_link !!}"--}}
{{--                                           rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{ \App\Helpers\UrlGen::page($page) }}" {!! $linkTarget !!}> {{ $page->name }} </a>--}}
{{--                                    @endif--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="{{ $colClass2 }}">--}}
{{--                <div class="footer-col">--}}
{{--                    <h4 class="footer-title">{{ t('Contact and Sitemap') }}</h4>--}}
{{--                    <ul class="list-unstyled footer-nav">--}}
{{--                        <li><a href="{{ \App\Helpers\UrlGen::contact() }}"> {{ t('Contact') }} </a></li>--}}
{{--                        <li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> {{ t('sitemap') }} </a></li>--}}
{{--                        @if (isset($countries) && $countries->count() > 1)--}}
{{--                            <li><a href="{{ \App\Helpers\UrlGen::countries() }}"> {{ t('countries') }} </a></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="{{ $colClass3 }}">--}}
{{--                <div class="footer-col">--}}
{{--                    <h4 class="footer-title">{{ t('My Account') }}</h4>--}}
{{--                    <ul class="list-unstyled footer-nav">--}}
{{--                        @if (!auth()->user())--}}
{{--                            <li>--}}
{{--                                @if (config('settings.security.login_open_in_modal'))--}}
{{--                                    <a href="#quickLogin" data-toggle="modal"> {{ t('log_in') }} </a>--}}
{{--                                @else--}}
{{--                                    <a href="{{ \App\Helpers\UrlGen::login() }}"> {{ t('log_in') }} </a>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                            <li><a href="{{ \App\Helpers\UrlGen::register() }}"> {{ t('register') }} </a></li>--}}
{{--                        @else--}}
{{--                            <li><a href="{{ url('account') }}"> {{ t('Personal Home') }} </a></li>--}}
{{--                            <li><a href="{{ url('account/my-posts') }}"> {{ t('my_ads') }} </a></li>--}}
{{--                            <li><a href="{{ url('account/favourite') }}"> {{ t('favourite_ads') }} </a></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            @if (--}}
{{--                config('settings.other.ios_app_url') or--}}
{{--                config('settings.other.android_app_url') or--}}
{{--                config('settings.social_link.facebook_page_url') or--}}
{{--                config('settings.social_link.twitter_url') or--}}
{{--                config('settings.social_link.google_plus_url') or--}}
{{--                config('settings.social_link.linkedin_url') or--}}
{{--                config('settings.social_link.pinterest_url') or--}}
{{--                config('settings.social_link.instagram_url')--}}
{{--                )--}}
{{--                <div class="{{ $colClass4 }}">--}}
{{--                    <div class="footer-col row">--}}
{{--                        <?php--}}
{{--                        $footerSocialClass = '';--}}
{{--                        $footerSocialTitleClass = '';--}}
{{--                        ?>--}}
{{--                        --}}{{-- @todo: API Plugin --}}
{{--                        @if (config('settings.other.ios_app_url') or config('settings.other.android_app_url'))--}}
{{--                            <div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">--}}
{{--                                <div class="mobile-app-content">--}}
{{--                                    <h4 class="footer-title">{{ t('Mobile Apps') }}</h4>--}}
{{--                                    <div class="row ">--}}
{{--                                        @if (config('settings.other.ios_app_url'))--}}
{{--                                            <div class="col-xs-12 col-sm-6">--}}
{{--                                                <a class="app-icon" target="_blank"--}}
{{--                                                   href="{{ config('settings.other.ios_app_url') }}">--}}
{{--                                                    <span class="hide-visually">{{ t('iOS app') }}</span>--}}
{{--                                                    <img src="{{ url('images/site/app-store-badge.svg') }}"--}}
{{--                                                         alt="{{ t('Available on the App Store') }}">--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.other.android_app_url'))--}}
{{--                                            <div class="col-xs-12 col-sm-6">--}}
{{--                                                <a class="app-icon" target="_blank"--}}
{{--                                                   href="{{ config('settings.other.android_app_url') }}">--}}
{{--                                                    <span class="hide-visually">{{ t('Android App') }}</span>--}}
{{--                                                    <img src="{{ url('images/site/google-play-badge.svg') }}"--}}
{{--                                                         alt="{{ t('Available on Google Play') }}">--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <?php--}}
{{--                            $footerSocialClass = 'hero-subscribe';--}}
{{--                            $footerSocialTitleClass = 'no-margin';--}}
{{--                            ?>--}}
{{--                        @endif--}}

{{--                        @if (--}}
{{--                            config('settings.social_link.facebook_page_url') or--}}
{{--                            config('settings.social_link.twitter_url') or--}}
{{--                            config('settings.social_link.google_plus_url') or--}}
{{--                            config('settings.social_link.linkedin_url') or--}}
{{--                            config('settings.social_link.pinterest_url') or--}}
{{--                            config('settings.social_link.instagram_url')--}}
{{--                            )--}}
{{--                            <div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">--}}
{{--                                <div class="{!! $footerSocialClass !!}">--}}
{{--                                    <h4 class="footer-title {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}</h4>--}}
{{--                                    <ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">--}}
{{--                                        @if (config('settings.social_link.facebook_page_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color fb" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.facebook_page_url') }}"--}}
{{--                                                   data-original-title="Facebook">--}}
{{--                                                    <i class="fab fa-facebook"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.social_link.twitter_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color tw" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.twitter_url') }}"--}}
{{--                                                   data-original-title="Twitter">--}}
{{--                                                    <i class="fab fa-twitter"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.social_link.instagram_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color pin" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.instagram_url') }}"--}}
{{--                                                   data-original-title="Instagram">--}}
{{--                                                    <i class="icon-instagram-filled"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.social_link.google_plus_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color gp" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.google_plus_url') }}"--}}
{{--                                                   data-original-title="Google+">--}}
{{--                                                    <i class="fab fa-google-plus"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.social_link.linkedin_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color lin" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.linkedin_url') }}"--}}
{{--                                                   data-original-title="LinkedIn">--}}
{{--                                                    <i class="fab fa-linkedin"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                        @if (config('settings.social_link.pinterest_url'))--}}
{{--                                            <li>--}}
{{--                                                <a class="icon-color pin" title="" data-placement="top"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   href="{{ config('settings.social_link.pinterest_url') }}"--}}
{{--                                                   data-original-title="Pinterest">--}}
{{--                                                    <i class="fab fa-pinterest-p"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div style="clear: both"></div>--}}
{{--        @endif--}}

{{--        <div class="col-xl-12">--}}
{{--            @if (!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0)--}}
{{--                <div class="text-center paymanet-method-logo">--}}
{{--                    --}}{{-- Payment Plugins --}}
{{--                    @foreach($paymentMethods as $paymentMethod)--}}
{{--                        @if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))--}}
{{--                            <img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}"--}}
{{--                                 alt="{{ $paymentMethod->display_name }}"--}}
{{--                                 title="{{ $paymentMethod->display_name }}">--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @else--}}
{{--                @if (!config('settings.footer.hide_links'))--}}
{{--                    <hr>--}}
{{--                @endif--}}
{{--            @endif--}}

{{--            <div class="copy-info text-center">--}}
{{--                © {{ date('Y') }} {{ config('settings.app.app_name') }}. {{ t('all_rights_reserved') }}.--}}
{{--                @if (!config('settings.footer.hide_powered_by'))--}}
{{--                    @if (config('settings.footer.powered_by_info'))--}}
{{--                        {{ t('Powered by') }} {!! config('settings.footer.powered_by_info') !!}--}}
{{--                    @else--}}
{{--                        {{ t('Powered by') }} <a href="https://www.ivylabtech.com" title="BedigitCom">IVYLAB TECHNOLOGIES</a>.--}}
{{--                    @endif--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}
<footer class="main-footer">
    <div class="footer-content border-0 py-0">
        <div class="footer-title-wrap d-none d-md-block py-3">
            <div class="container">
                <div class="row">
                    @if (!config('settings.footer.hide_links'))
                        <div class="{{ $colClass1 }}">
                            <div class="footer-col">
                                <h4 class="footer-title d-flex align-items-center">{{ t('about_us') }}</h4>
                            </div>
                        </div>
                        <div class="{{ $colClass2 }}">
                            <div class="footer-col">
                                <h4 class="footer-title d-flex align-items-center">{{ t('Contact and Sitemap') }}</h4>
                            </div>
                        </div>
                        <div class="{{ $colClass3 }}">
                            <div class="footer-col">
                                <h4 class="footer-title d-flex align-items-center">{{ t('My Account') }}</h4>
                            </div>
                        </div>
                        <div class="{{ $colClass4 }}">
                            <?php
                            $footerSocialClass = '';
                            $footerSocialTitleClass = '';
                            ?>
                            <div class="{!! $footerSocialClass !!}">
                                <h4 class="footer-title d-flex align-items-center {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}</h4>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer-content-wrap py-3 py-md-4">
            <div class="container">
                <div class="row">

                    @if (!config('settings.footer.hide_links'))
                        <div class="{{ $colClass1 }}">
                            <div class="footer-col">
                                <h4 class="d-flex align-items-end d-md-none footer-title">{{ t('about_us') }}</h4>
                                <ul class="list-unstyled footer-nav">
                                    @if (isset($pages) and $pages->count() > 0)
                                        @foreach($pages as $page)
                                            <li>
                                                <?php
                                                $linkTarget = '';
                                                if ($page->target_blank == 1) {
                                                    $linkTarget = 'target="_blank"';
                                                }
                                                ?>
                                                @if (!empty($page->external_link))
                                                    <a href="{!! $page->external_link !!}"
                                                       rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>
                                                @else
                                                    <a href="{{ \App\Helpers\UrlGen::page($page) }}" {!! $linkTarget !!}> {{ $page->name }} </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="{{ $colClass2 }}">
                            <div class="footer-col">
                                <h4 class="d-flex align-items-end d-md-none footer-title">{{ t('Contact and Sitemap') }}</h4>
                                <ul class="list-unstyled footer-nav">
                                    <li><a href="{{ \App\Helpers\UrlGen::contact() }}"> {{ t('Contact') }} </a></li>
                                    <li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> {{ t('sitemap') }} </a></li>
                                    @if (isset($countries) && $countries->count() > 1)
                                        <li><a href="{{ \App\Helpers\UrlGen::countries() }}"> {{ t('countries') }} </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="{{ $colClass3 }}">
                            <div class="footer-col">
                                <h4 class="d-flex align-items-end d-md-none footer-title">{{ t('My Account') }}</h4>
                                <ul class="list-unstyled footer-nav">
                                    @if (!auth()->user())
                                        <li>
                                            @if (config('settings.security.login_open_in_modal'))
                                                <a href="#quickLogin" data-toggle="modal"> {{ t('log_in') }} </a>
                                            @else
                                                <a href="{{ \App\Helpers\UrlGen::login() }}"> {{ t('log_in') }} </a>
                                            @endif
                                        </li>
                                        <li><a href="{{ \App\Helpers\UrlGen::register() }}"> {{ t('register') }} </a>
                                        </li>
                                    @else
                                        <li><a href="{{ url('account') }}"> {{ t('Personal Home') }} </a></li>
                                        <li><a href="{{ url('account/my-posts') }}"> {{ t('my_ads') }} </a></li>
                                        <li><a href="{{ url('account/favourite') }}"> {{ t('favourite_ads') }} </a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if (
                            config('settings.other.ios_app_url') or
                            config('settings.other.android_app_url') or
                            config('settings.social_link.facebook_page_url') or
                            config('settings.social_link.twitter_url') or
                            config('settings.social_link.google_plus_url') or
                            config('settings.social_link.linkedin_url') or
                            config('settings.social_link.pinterest_url') or
                            config('settings.social_link.instagram_url')
                            )
                            <div class="{{ $colClass4 }}">
                                <div class="footer-col row">
                                    <?php
                                    $footerSocialClass = '';
                                    $footerSocialTitleClass = '';
                                    ?>
                                    {{-- @todo: API Plugin --}}
                                    @if (config('settings.other.ios_app_url') or config('settings.other.android_app_url'))
                                        <div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
                                            <div class="mobile-app-content">
                                                <h4 class="d-flex align-items-end d-md-none footer-title">{{ t('Mobile Apps') }}</h4>
                                                <div class="row ">
                                                    @if (config('settings.other.ios_app_url'))
                                                        <div class="col-xs-12 col-sm-6">
                                                            <a class="app-icon" target="_blank"
                                                               href="{{ config('settings.other.ios_app_url') }}">
                                                                <span class="hide-visually">{{ t('iOS app') }}</span>
                                                                <img src="{{ url('images/site/app-store-badge.svg') }}"
                                                                     alt="{{ t('Available on the App Store') }}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if (config('settings.other.android_app_url'))
                                                        <div class="col-xs-12 col-sm-6">
                                                            <a class="app-icon" target="_blank"
                                                               href="{{ config('settings.other.android_app_url') }}">
                                                                <span class="hide-visually">{{ t('Android App') }}</span>
                                                                <img src="{{ url('images/site/google-play-badge.svg') }}"
                                                                     alt="{{ t('Available on Google Play') }}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $footerSocialClass = 'hero-subscribe';
                                        $footerSocialTitleClass = 'no-margin';
                                        ?>
                                    @endif

                                    @if (
                                        config('settings.social_link.facebook_page_url') or
                                        config('settings.social_link.twitter_url') or
                                        config('settings.social_link.google_plus_url') or
                                        config('settings.social_link.linkedin_url') or
                                        config('settings.social_link.pinterest_url') or
                                        config('settings.social_link.instagram_url')
                                        )
                                        <div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
                                            <div class="{!! $footerSocialClass !!}">
                                                <h4 class="d-flex align-items-end d-md-none footer-title {!! $footerSocialTitleClass !!}">{{ t('Follow us on') }}</h4>
                                                <ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
                                                    @if (config('settings.social_link.facebook_page_url'))
                                                        <li>
                                                            <a class="icon-color " title="Facebook" data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.facebook_page_url') }}"
                                                               data-original-title="Facebook">
                                                                <i class="fab fa-facebook fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (config('settings.social_link.twitter_url'))
                                                        <li>
                                                            <a class="icon-color " title="Twitter" data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.twitter_url') }}"
                                                               data-original-title="Twitter">
                                                                <i class="fab fa-twitter fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (config('settings.social_link.instagram_url'))
                                                        <li>
                                                            <a class="icon-color " title="Instagram"
                                                               data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.instagram_url') }}"
                                                               data-original-title="Instagram">
                                                                <i class="fab fa-instagram fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (config('settings.social_link.google_plus_url'))
                                                        <li>
                                                            <a class="icon-color " title="Google+" data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.google_plus_url') }}"
                                                               data-original-title="Google+">
                                                                <i class="fab fa-google-plus fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (config('settings.social_link.linkedin_url'))
                                                        <li>
                                                            <a class="icon-color " title="LinkedIn" data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.linkedin_url') }}"
                                                               data-original-title="LinkedIn">
                                                                <i class="fab fa-linkedin fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (config('settings.social_link.pinterest_url'))
                                                        <li>
                                                            <a class="icon-color " title="Pinterest"
                                                               data-placement="top"
                                                               data-toggle="tooltip"
                                                               href="{{ config('settings.social_link.pinterest_url') }}"
                                                               data-original-title="Pinterest">
                                                                <i class="fab fa-pinterest-p fa-2x"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div style="clear: both"></div>
                    @endif

                    <div class="col-xl-12">
                        @if (!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0)
                            <div class="text-center paymanet-method-logo">
                                {{-- Payment Plugins --}}
                                @foreach($paymentMethods as $paymentMethod)
                                    @if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))
                                        <img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}"
                                             alt="{{ $paymentMethod->display_name }}"
                                             title="{{ $paymentMethod->display_name }}">
                                    @endif
                                @endforeach
                            </div>
{{--                        @else--}}
{{--                            @if (!config('settings.footer.hide_links'))--}}
{{--                                <hr>--}}
{{--                            @endif--}}
                        @endif
                        @if (!config('settings.footer.hide_powered_by'))
                            <div class="copy-info text-center">
                                © {{ date('Y') }} {{ config('settings.app.app_name') }}. {{ t('all_rights_reserved') }}.
                                @if (config('settings.footer.powered_by_info'))
                                    {{ t('Powered by') }} {!! config('settings.footer.powered_by_info') !!}
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>
