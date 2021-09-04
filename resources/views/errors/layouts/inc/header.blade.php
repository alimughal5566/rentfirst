<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
$main = "";
// Logo Label
$logoLabel = '';
if (request()->segment(1) != 'countries') {
    if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
        $logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
    }
}
?>
<div class="header">
    <nav class="header-main navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">

            <div class="navbar-identity">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ imgUrl(config('settings.app.logo', config('larapen.core.logo')), 'logo') }}"
                         class="tooltipHere main-logo"/>
                </a>
                {{-- Toggle Nav (Mobile) --}}
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right"
                        type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30"
                         focusable="false">
                        <title>{{ t('Menu') }}</title>
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10"
                              d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </button>
                {{-- Country Flag (Mobile) --}}
                @if (request()->segment(1) != 'countries')
                    @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                        @if (!empty(config('country.icode')))
                            @if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
                                <button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right"
                                        href="#selectCountry" data-toggle="modal">
                                    <img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}"
                                         alt="{{ config('country.name') }}"
                                         style="float: left;"
                                    >
                                    <span class="caret hidden-xs"></span>
                                </button>
                            @endif
                        @endif
                    @endif
                @endif
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    {{-- Country Flag --}}
                    @if (request()->segment(1) != 'countries')
                        @if (config('settings.geo_location.country_flag_activation'))
                            @if (!empty(config('country.icode')))
                                @if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
                                    <li class="flag-menu country-flag tooltipHere hidden-xs nav-item"
                                        data-toggle="tooltip"
                                        data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}">
                                        @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                                            <a href="#selectCountry" data-toggle="modal" class="nav-link">
                                                <img class="flag-icon" alt="{{ config('country.name') }}"
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}">
                                                <span class="caret hidden-sm"></span>
                                            </a>
                                        @else
                                            <a style="cursor: default;">
                                                <img class="flag-icon no-caret" alt="{{ config('country.name') }}"
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}">
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            @endif
                        @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav ml-auto navbar-right">
                    @if (!auth()->check())
                        <li class="nav-item">
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link">
                                <i class="icon-user fa"></i> {{ t('log_in') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link">
                                <i class="icon-user-add fa"></i> {{ t('register') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            @if (app('impersonate')->isImpersonating())
                                <a href="{{ route('impersonate.leave') }}" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
                                </a>
                            @else
                                <a href="{{ \App\Helpers\UrlGen::logout() }}" class="nav-link">
                                    <i class="glyphicon glyphicon-off"></i> {{ t('log_out') }}
                                </a>
                            @endif
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="icon-user fa hidden-sm"></i>
                                <span>{{ auth()->user()->name }}</span>
                                <i class="icon-down-open-big fa"></i>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="{{ url('account') }}">
                                        <i class="icon-home"></i> {{ t('Personal Home') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/my-posts') }}">
                                        <i class="icon-th-thumb"></i> {{ t('my_ads') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/favourite') }}">
                                        <i class="icon-heart"></i> {{ t('favourite_ads') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/saved-search') }}">
                                        <i class="icon-star-circled"></i> {{ t('Saved searches') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/pending-approval') }}">
                                        <i class="icon-hourglass"></i> {{ t('pending_approval') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/archived') }}">
                                        <i class="icon-folder-close"></i> {{ t('archived_ads') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/messages') }}">
                                        <i class="icon-mail-1"></i> {{ t('messenger') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/transactions') }}">
                                        <i class="icon-money"></i> {{ t('Transactions') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

{{--                    <li class="nav-item postadd">--}}
{{--                        @if (!auth()->check())--}}
{{--                            @if (config('settings.single.guests_can_post_ads') != '1')--}}
{{--                                <a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin"--}}
{{--                                   data-toggle="modal">--}}
{{--                                    <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
{{--                                </a>--}}
{{--                            @else--}}
{{--                                <a class="btn btn-block btn-border btn-post btn-add-listing"--}}
{{--                                   href="{{ \App\Helpers\UrlGen::addPost(true) }}">--}}
{{--                                    <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <a class="btn btn-block btn-border btn-post btn-add-listing"--}}
{{--                               href="{{ \App\Helpers\UrlGen::addPost(true) }}">--}}
{{--                                <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    </li>--}}

                    @if (!empty(config('lang.abbr')))
                        @if (is_array(getSupportedLanguages()) && count(getSupportedLanguages()) > 1)
                        <!-- Language selector -->
                            <li class="dropdown lang-menu nav-item">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                    <span class="lang-title">{{ strtoupper(config('app.locale')) }}</span>
                                </button>
                                <ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm"
                                    role="menu">
                                    @foreach(getSupportedLanguages() as $langCode => $lang)
                                        @continue(strtolower($langCode) == strtolower(config('app.locale')))
                                        <li class="dropdown-item">
                                            <a href="{{ url('lang/' . $langCode) }}" tabindex="-1" rel="alternate"
                                               hreflang="{{ $langCode }}">
                                                <span class="lang-name">{{{ $lang['native'] }}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="header-navigation ">
        <div class="container">
            <div class="header-nav-wrap d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap position-relative pt-1 pb-2 pb-md-1">

                <div class="order-1 dropdown position-md-unset">
                    <button class="btn dropdown-toggle font-weight-bold text-white text-uppercase" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        All Categories
                    </button>
                    <div class="dropdown-menu wp-100 p-0" aria-labelledby="dropdownMenuButton">
                        <div class="d-flex flex-wrap vertical-menu px-3 py-1">
                            @if(isset($main))
                            @foreach($main as $main_key => $main_category)
                                <div class="wp-100 wp-sm-50 wp-md-20 main-item py-2">
                                    <a class="dropdown-item"
                                       href="{{ \App\Helpers\UrlGen::category($main_category) }}">
                                        <i class="{{ $main_category->icon_class ?? 'icon-ok' }}"></i>
                                        <span class="font-weight-bold">
                                            {{$main_category->name}}
                                        </span>
                                    </a>

                                    <div class="sub-menu">
                                        @if(isset($main_category->Subcategories))
                                            @foreach($main_category->Subcategories->take(5) as $sub_main_category)
                                                <span class="submenu-item">
                                                    <a class="dropdown-item"
                                                       href="{{ \App\Helpers\UrlGen::category($sub_main_category, 1) }}">{{$sub_main_category->name}}</a>
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="order-3 order-md-2 navigation-special">
                    @if(isset($main))
                    @foreach($main->take(4) as $main_category)
                        <a class="dropdown-item d-inline-flex align-items-center justify-content-center px-2"
                           href="{{ \App\Helpers\UrlGen::category($main_category) }}">
                            <i class="mr-2 {{ $main_category->icon_class ?? 'icon-ok' }}"></i>
                            <span class="font-weight-normal">{{$main_category->name}}</span>
                        </a>
                    @endforeach
                        @endif
                </div>

                <div class="order-2 order-md-3 category-add">
                    <ul class="nav navbar-nav">
                        <li class="nav-item postadd">
                            @if (!auth()->check())
                                @if (config('settings.single.guests_can_post_ads') != '1')
                                    <a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin"
                                       data-toggle="modal">
                                        {{--                                        <i class="fa fa-plus-circle"></i> --}}
                                        <img src="{{asset('images/site/cat.png')}}" alt="cat">
                                        <span>{{ 'RENT' }}</span>
                                    </a>
                                @else
                                    <a class="btn btn-block btn-border btn-post btn-add-listing"
                                       href="{{ \App\Helpers\UrlGen::addPost() }}">
                                        {{--                                        <i class="fa fa-plus-circle"></i> --}}
                                        <img src="{{asset('images/site/cat.png')}}" alt="cat">
                                        <span>{{ 'RENT' }}</span>
                                    </a>
                                @endif
                            @else
                                <a class="btn btn-block btn-border btn-post btn-add-listing px-4 py-2"
                                   href="{{ \App\Helpers\UrlGen::addPost() }}">
                                    {{--                                    <i class="fa fa-plus-circle"></i> --}}
                                    <img src="{{asset('images/site/cat.png')}}" alt="cat" class="img-fluid">
                                    <span>{{ 'RENT' }}</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>
