<?php
// Search parameters
use App\Models\MessageRequest;$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

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
if (request()->segment(1) != 'countries') {
    if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
        $logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
    }
}
$main = \App\Models\Category::with('Subcategories')->where('parent_id', NULL)->where('active', 1)->get()->take(10);
// $subs = \App\Models\Category::where('parent_id', '!=', NULL)->get()->take(8);

// dd($main);
?>
<div class="header">
    <nav class="header-main navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
        <div class="container">

            <div class="navbar-identity">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="navbar-brand logo logo-title">
                    <img src="{{ imgUrl(config('settings.app.logo'), 'logo') }}"
                         alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" title=""
                         data-placement="bottom"
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
                @if (request()->segment(1) != 'countries')
                    @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                        @if (!empty(config('country.icode')))
                            @if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
                                <button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right"
                                        href="#selectCountry" data-toggle="modal">
                                    <img src="{{ url('images/flags/24/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                         alt="{{ config('country.name') }}"
                                         style="float: left;">
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
                                        data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}" {!! $multiCountriesLabel !!}>
                                        @if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
                                            <a href="#selectCountry" data-toggle="modal" class="nav-link">
                                                <img class="flag-icon"
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                                     alt="{{ config('country.name') }}">
                                                <span class="caret hidden-sm"></span>
                                            </a>
                                        @else
                                            <a style="cursor: default;">
                                                <img class="flag-icon no-caret"
                                                     src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
                                                     alt="{{ config('country.name') }}">
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
                                    <i class="icon-user fa"></i> {{ t('log_in') }}</a>
                            @else
                                <a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link">
                                    <i class="icon-user fa"></i> {{ t('log_in') }}</a>
                            @endif
                        </li>
                        <li class="nav-item hidden-sm">
                            <a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link">
                                <i class="icon-user-add fa"></i> {{ t('register') }}</a>
                        </li>
                    @else
                        <li class="nav-item hidden-sm">
                            @if (app('impersonate')->isImpersonating())
                                <a href="{{ route('impersonate.leave') }}" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> {{ t('Leave') }}
                                </a>
                            @else
                                <!-- <a href="{{ \App\Helpers\UrlGen::logout() }}" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> {{ t('log_out') }}
                                </a> -->
                            @endif
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('account/messages') }}" class="main_requests">
                                <i class="icon-mail-1"></i> 
                                <span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
                            </a>
                        </li>

                        <!-- <li class="nav-item main_notification">
                            <a href="#" >
                                <i class="icon icon-bell"></i>
                                <span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
                                
                            </a>
                            <div class="all_notification">
                                <div class="start_custom_notification">
                                    <div class="main_noti">
                                        <div class="message_noti">
                                            <img src="{{ url('assets/img/dummy-image.jpg') }}" class="img-fluid"  >
                                            <a href="#">Umair send a message</a>
                                        </div> 
                                        <span class="noti_time">
                                            5min ago
                                        </span>
                                    </div>
                                    <div class="main_noti">
                                        <div class="message_noti">
                                            <img src="{{ url('assets/img/dummy-image.jpg') }}" class="img-fluid"  >
                                            <a href="#">Ali send a message</a>
                                        </div> 
                                        <span class="noti_time">
                                            5min ago
                                        </span>
                                    </div>
                                    <div class="main_noti">
                                        <div class="message_noti">
                                            <img src="{{ url('assets/img/dummy-image.jpg') }}" class="img-fluid"  >
                                            <a href="#">Popo send a message</a>
                                        </div> 
                                        <span class="noti_time">
                                            5min ago
                                        </span>
                                    </div>
                                    <div class="all_noti_main">
                                        <a href="#">See all notification</a>
                                    </div>
                                </div>
                            </div>
                        </li> -->

                    @if(auth()->check())
                                    <?php
                                    $check = App\Models\MessageRequest::where('status', 0)->where('add_owner', auth()->id())->get();
                                    ?>

                                    @if(!$check->isEmpty())
                                        <!-- <li class="nav-item">
                                            {{--									<a href="{{ url('messageRequest') }}">--}}
                                            <a href="#" class="main_requests" data-toggle="modal" data-target="#exampleModal">
                                                <i class="icon-mail-1"></i>
                                                <span class="badge badge-pill badge-important ">{{$check->count()}}</span>
                                            </a>
                                        </li> -->
                                    @endif

                                    @endif

                        <li class="nav-item dropdown no-arrow user-profile-wrap">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="icon-user fa hidden-sm"></i>
                                <span>{{ auth()->user()->name }}</span>
                                <span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span>
                                <i class="icon-down-open-big fa hidden-sm"></i>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="{{ url('account') }}">
                                        <i class="icon-home"></i> {{ t('Personal Home') }}
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/my-posts') }}">
                                        <i class="icon-th-thumb"></i> {{ t('my_ads') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/favourite') }}">
                                        <i class="icon-heart"></i> {{ t('favourite_ads') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/saved-search') }}">
                                        <i class="icon-star-circled"></i> {{ t('Saved searches') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/pending-approval') }}">
                                        <i class="icon-hourglass"></i> {{ t('pending_approval') }} </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="{{ url('account/archived') }}">
                                        <i class="icon-folder-close"></i> {{ t('archived_ads') }}</a>
                                </li>
                                
                                @if(auth()->check())
                                    


                                    <li class="dropdown-item"><a href="{{ url('account/transactions') }}"><i
                                                    class="icon-money"></i> {{ t('Transactions') }}</a></li>
                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-item">
                                        @if (app('impersonate')->isImpersonating())
                                            <a href="{{ route('impersonate.leave') }}"><i
                                                        class="icon-logout"></i> {{ t('Leave') }}</a>
                                        @else
                                            <a href="{{ \App\Helpers\UrlGen::logout() }}"><i
                                                        class="icon-logout"></i> {{ t('log_out') }}</a>
                                        @endif
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (config('plugins.currencyexchange.installed'))
                        @include('currencyexchange::select-currency')
                    @endif

                    @if (config('settings.single.pricing_page_enabled') == '2')
                        <li class="nav-item pricing">
                            <a href="{{ \App\Helpers\UrlGen::pricing() }}" class="nav-link">
                                <i class="fas fa-tags"></i> {{ t('pricing_label') }}
                            </a>
                        </li>
                    @endif

                    <?php
                    $addListingUrl = \App\Helpers\UrlGen::addPost();
                    $addListingAttr = '';
                    if (!auth()->check()) {
                        if (config('settings.single.guests_can_post_ads') != '1') {
                            $addListingUrl = '#quickLogin';
                            $addListingAttr = ' data-toggle="modal"';
                        }
                    }
                    if (config('settings.single.pricing_page_enabled') == '1') {
                        $addListingUrl = \App\Helpers\UrlGen::pricing();
                        $addListingAttr = '';
                    }
                    ?>
                    {{--                    <li class="nav-item postadd">--}}
                    {{--                        <a class="btn btn-block btn-border btn-post btn-add-listing"--}}
                    {{--                           href="{{ $addListingUrl }}"{!! $addListingAttr !!}>--}}
                    {{--                            <i class="fa fa-plus-circle"></i> {{ t('Add Listing') }}--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}

                    @includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language', 'layouts.inc.menu.select-language'])

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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Message Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{--				php for message request starts here--}}

                {{--				php for message request ends here--}}
                @if(auth()->check())
                    <table id="addManageTable"
                           class="table table-striped table-bordered add-manage-table table demo footable-loaded footable"
                           data-filter="#filter" data-filter-text-only="true">
                        <thead>
                        <tr>
                            <th>Requester</th>
                            <th data-sort-ignore="true">Ads Details</th>
                            <th data-type="numeric">Price</th>
                            <th>Option</th>
                        </tr>
                        </thead>
                        <tbody id="addetail">
                        @foreach($check as $ch)

                            <tr>
                                <td style="width:14%" class="add-img-td">
                                    <p>{{$ch->user->name}}</p>
                                </td>
                                <td style="width:58%" class="items-details-td">
                                    <div>
                                        <p>
                                            <strong>
                                                <a href="{{ \App\Helpers\UrlGen::post($ch->post) }}"
                                                   title="{{$ch->post->title}}">{{$ch->post->title}}</a>
                                            </strong>
                                        </p>


                                    </div>
                                </td>
                                <td style="width:16%" class="price-td">
                                    <div>
                                        <strong>
                                            Rs.{{$ch->post->price}}
                                        </strong>
                                    </div>
                                </td>
                                <td style="width:10%" class="action-td">
                                    <div>
                                        <p>
                                        <form method="POST" action="{{route('messageApprove')}}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{$ch->user_id}}">
                                            <button class="btn btn-primary btn-sm confirm-action" type="submit">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                        </form>
                                        </p>
                                        <p>
                                        <form method="POST" action="{{route('messageDecline')}}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$ch->id}}">
                                            <button class="btn btn-danger btn-sm delete-action" type="submit"
                                                    onclick="return confirm('Are you sure you want to decline this request?');">
                                                <i class="fa fa-trash"></i> Decline
                                            </button>
                                        </form>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                {{--				<button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("#close").click(function () {
            $('#addetail').reset();
        });
    });
</script>



