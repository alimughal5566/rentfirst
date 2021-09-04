<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.optimization.cache_expiration', 86400);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
    if (!empty(config('country.code'))) {
        if (\App\Models\Country::where('active', 1)->count() > 1) {
            $multiCountriesIsEnabled = true;
            $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
        }
    }
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
    $logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
}
$main = \App\Models\Category::with('Subcategories')->where('parent_id', 0)->where('active', 1)->get()->take(8);

?>
<div class="header">
    <nav class="header-main navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">

            <div class="navbar-identity">
                {{-- Logo --}}
                <a href="{{ lurl('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ imgUrl(config('settings.app.logo'), 'logo') }}"
                         alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo"
                         title="" data-placement="bottom"
                         data-toggle="tooltip"
                         data-original-title="{!! isset($logoLabel) ? $logoLabel : '' !!}"/>
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
                @if (getSegment(1) != trans('routes.countries'))
                    @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                        @if (!empty(config('country.icode')))
                            @if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
                                <button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right"
                                        href="#selectCountry" data-toggle="modal">
                                    <img src="{{ url('images/flags/24/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                         style="float: left;">
                                    <span class="caret hidden-xs"></span>
                                </button>
                            @endif
                        @endif
                    @endif
                @endif
            </div>
            {{--@dd($main->name);--}}

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    {{-- Country Flag --}}
                    @if (getSegment(1) != trans('routes.countries'))
                        @if (config('settings.geo_location.country_flag_activation'))
                            @if (!empty(config('country.icode')))
                                @if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
                                    <li class="flag-menu country-flag tooltipHere hidden-xs nav-item"
                                        data-toggle="tooltip"
                                        data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
                                        @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                                            <a href="#selectCountry" data-toggle="modal" class="nav-link">
                                                <img class="flag-icon" alt=""
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}">
                                                <span class="caret hidden-sm"></span>
                                            </a>
                                        @else
                                            <a style="cursor: default;">
                                                <img class="flag-icon no-caret" alt=""
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}">
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            @endif
                        @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav ml-auto navbar-right align-items-center">
                    @if (!auth()->check())
                        <li class="nav-item">
                            @if (config('settings.security.login_open_in_modal'))
                                <a href="#quickLogin" class="nav-link" data-toggle="modal">
                                    <i class="icon-user fa"></i> {{ t('Log In') }}</a>
                            @else
                                <a href="{{ lurl(trans('routes.login')) }}" class="nav-link">
                                    <i class="icon-user fa"></i> {{ t('Log In') }}</a>
                            @endif
                        </li>
                        <li class="nav-item">
                            <a href="{{ lurl(trans('routes.register')) }}" class="nav-link">
                                <i class="icon-user-add fa"></i> {{ t('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            @if (app('impersonate')->isImpersonating())
                                <a href="{{ route('impersonate.leave') }}" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
                                </a>
                            @else
                                <a href="{{ lurl(trans('routes.logout')) }}" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> {{ t('Log Out') }}
                                </a>
                            @endif
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle nav-link user-image-wrap" data-toggle="dropdown">
                                <span class="user-image d-flex justify-content-center align-items-center">
                                    <img class="img-fluid" src="{{asset('images/user.jpg')}}" alt="">
                                    <i class="icon-user fa hidden-sm"></i>
                                    <span class="badge badge-pill badge-important count-conversations-with-new-messages hidden-sm">0</span>
                                    <i class="icon-down-open-big fa hidden-sm"></i>
                                </span>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="{{ lurl('account') }}">
                                        <span>{{ auth()->user()->name }}</span>
                                    </a>
                                </li>
                                {{--                                <li class="dropdown-item ">--}}
                                {{--                                    <a href="{{ lurl('account') }}">--}}
                                {{--                                        <i class="icon-home"></i> {{ t('Personal Home') }}--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/my-posts') }}">
                                        <i class="far fa-thumbs-up"></i> {{ t('My ads') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/favourite') }}">
                                        <i class="fas fa-heart"></i> {{ t('Favourite ads') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/saved-search') }}">
                                        <i class="fas fa-star"></i> {{ t('Saved searches') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/pending-approval') }}">
                                        <i class="fas fa-hourglass-start"></i> {{ t('Pending approval') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/archived') }}">
                                        <i class="fas fa-folder"></i> {{ t('Archived ads') }}</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/conversations') }}">
                                        <i class="fas fa-comment-dots"></i> {{ t('Conversations') }}
                                        <span class="badge badge-pill badge-important count-conversations-with-new-messages">0</span>
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ lurl('account/transactions') }}">
                                        <i class="fas fa-money-bill"></i> {{ t('Transactions') }}</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (config('plugins.currencyexchange.installed'))
                        @include('currencyexchange::select-currency')
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
                    {{--                                   href="{{ \App\Helpers\UrlGen::addPost() }}">--}}
                    {{--                                    <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
                    {{--                                </a>--}}
                    {{--                            @endif--}}
                    {{--                        @else--}}
                    {{--                            <a class="btn btn-block btn-border btn-post btn-add-listing"--}}
                    {{--                               href="{{ \App\Helpers\UrlGen::addPost() }}">--}}
                    {{--                                <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
                    {{--                            </a>--}}
                    {{--                        @endif--}}
                    {{--                    </li>--}}

                    @include('layouts.inc.menu.select-language')

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
                        </div>
                    </div>
                </div>

                <div class="order-3 order-md-2 navigation-special">
                    @foreach($main->take(4) as $main_category)
                        <a class="dropdown-item d-inline-flex align-items-center justify-content-center px-2"
                           href="{{ \App\Helpers\UrlGen::category($main_category) }}">
                            <i class="mr-2 {{ $main_category->icon_class ?? 'icon-ok' }}"></i>
                            <span class="font-weight-normal">{{$main_category->name}}</span>
                        </a>
                    @endforeach
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
