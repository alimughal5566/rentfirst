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
                
                <a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
                    <img src="<?php echo e(imgUrl(config('settings.app.logo'), 'logo')); ?>"
                         alt="<?php echo e(strtolower(config('settings.app.app_name'))); ?>" class="tooltipHere main-logo" title=""
                         data-placement="bottom"
                         data-toggle="tooltip"
                         data-original-title="<?php echo isset($logoLabel) ? $logoLabel : ''; ?>"/>
                </a>
                
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggler pull-right"
                        type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30" height="30"
                         focusable="false">
                        <title><?php echo e(t('Menu')); ?></title>
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10"
                              d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </button>
                
                <?php if(request()->segment(1) != 'countries'): ?>
                    <?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
                        <?php if(!empty(config('country.icode'))): ?>
                            <?php if(file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png')): ?>
                                <button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right"
                                        href="#selectCountry" data-toggle="modal">
                                    <img src="<?php echo e(url('images/flags/24/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
                                         alt="<?php echo e(config('country.name')); ?>"
                                         style="float: left;">
                                    <span class="caret hidden-xs"></span>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    
                    <?php if(request()->segment(1) != 'countries'): ?>
                        <?php if(config('settings.geo_location.country_flag_activation')): ?>
                            <?php if(!empty(config('country.icode'))): ?>
                                <?php if(file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png')): ?>
                                    <li class="flag-menu country-flag tooltipHere hidden-xs nav-item"
                                        data-toggle="tooltip"
                                        data-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>" <?php echo $multiCountriesLabel; ?>>
                                        <?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
                                            <a href="#selectCountry" data-toggle="modal" class="nav-link">
                                                <img class="flag-icon"
                                                     src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
                                                     alt="<?php echo e(config('country.name')); ?>">
                                                <span class="caret hidden-sm"></span>
                                            </a>
                                        <?php else: ?>
                                            <a style="cursor: default;">
                                                <img class="flag-icon no-caret"
                                                     src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>"
                                                     alt="<?php echo e(config('country.name')); ?>">
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <ul class="nav navbar-nav ml-auto navbar-right align-items-center">
                    <?php if(!auth()->check()): ?>
                    
                        <li class="nav-item">
                            <?php if(config('settings.security.login_open_in_modal')): ?>
                                <a href="#quickLogin" class="nav-link" data-toggle="modal">
                                    <i class="icon-user fa"></i> <?php echo e(t('log_in')); ?></a>
                            <?php else: ?>
                                <a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link">
                                    <i class="icon-user fa"></i> <?php echo e(t('log_in')); ?></a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item hidden-sm">
                            <a href="<?php echo e(\App\Helpers\UrlGen::register()); ?>" class="nav-link">
                                <i class="icon-user-add fa"></i> <?php echo e(t('register')); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item hidden-sm">
                            <?php if(app('impersonate')->isImpersonating()): ?>
                                <a href="<?php echo e(route('impersonate.leave')); ?>" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> <?php echo e(t('Leave')); ?>

                                </a>
                            <?php else: ?>
                                <!-- <a href="<?php echo e(\App\Helpers\UrlGen::logout()); ?>" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> <?php echo e(t('log_out')); ?>

                                </a> -->
                            <?php endif; ?>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo e(url('account/messages')); ?>" class="main_requests">
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
                                            <img src="<?php echo e(url('assets/img/dummy-image.jpg')); ?>" class="img-fluid"  >
                                            <a href="#">Umair send a message</a>
                                        </div> 
                                        <span class="noti_time">
                                            5min ago
                                        </span>
                                    </div>
                                    <div class="main_noti">
                                        <div class="message_noti">
                                            <img src="<?php echo e(url('assets/img/dummy-image.jpg')); ?>" class="img-fluid"  >
                                            <a href="#">Ali send a message</a>
                                        </div> 
                                        <span class="noti_time">
                                            5min ago
                                        </span>
                                    </div>
                                    <div class="main_noti">
                                        <div class="message_noti">
                                            <img src="<?php echo e(url('assets/img/dummy-image.jpg')); ?>" class="img-fluid"  >
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

                    <?php if(auth()->check()): ?>
                                    <?php
                                    $check = App\Models\MessageRequest::where('status', 0)->where('add_owner', auth()->id())->get();
                                    ?>

                                    <?php if(!$check->isEmpty()): ?>
                                        <!-- <li class="nav-item">
                                            
                                            <a href="#" class="main_requests" data-toggle="modal" data-target="#exampleModal">
                                                <i class="icon-mail-1"></i>
                                                <span class="badge badge-pill badge-important "><?php echo e($check->count()); ?></span>
                                            </a>
                                        </li> -->
                                    <?php endif; ?>

                                    <?php endif; ?>

                        <li class="nav-item dropdown no-arrow user-profile-wrap">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="icon-user fa hidden-sm"></i>
                                <span><?php echo e(auth()->user()->name); ?></span>
                                <span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span>
                                <i class="icon-down-open-big fa hidden-sm"></i>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="<?php echo e(url('account')); ?>">
                                        <i class="icon-home"></i> <?php echo e(t('Personal Home')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/my-posts')); ?>">
                                        <i class="icon-th-thumb"></i> <?php echo e(t('my_ads')); ?> </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/favourite')); ?>">
                                        <i class="icon-heart"></i> <?php echo e(t('favourite_ads')); ?> </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/saved-search')); ?>">
                                        <i class="icon-star-circled"></i> <?php echo e(t('Saved searches')); ?> </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/pending-approval')); ?>">
                                        <i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?> </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/archived')); ?>">
                                        <i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?></a>
                                </li>
                                
                                <?php if(auth()->check()): ?>
                                    


                                    <li class="dropdown-item"><a href="<?php echo e(url('account/transactions')); ?>"><i
                                                    class="icon-money"></i> <?php echo e(t('Transactions')); ?></a></li>
                                    <li class="dropdown-divider"></li>
                                    <li class="dropdown-item">
                                        <?php if(app('impersonate')->isImpersonating()): ?>
                                            <a href="<?php echo e(route('impersonate.leave')); ?>"><i
                                                        class="icon-logout"></i> <?php echo e(t('Leave')); ?></a>
                                        <?php else: ?>
                                            <a href="<?php echo e(\App\Helpers\UrlGen::logout()); ?>"><i
                                                        class="icon-logout"></i> <?php echo e(t('log_out')); ?></a>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(config('plugins.currencyexchange.installed')): ?>
                        <?php echo $__env->make('currencyexchange::select-currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <?php if(config('settings.single.pricing_page_enabled') == '2'): ?>
                        <li class="nav-item pricing">
                            <a href="<?php echo e(\App\Helpers\UrlGen::pricing()); ?>" class="nav-link">
                                <i class="fas fa-tags"></i> <?php echo e(t('pricing_label')); ?>

                            </a>
                        </li>
                    <?php endif; ?>

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
                    
                    
                    
                    
                    
                    

                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.menu.select-language', 'layouts.inc.menu.select-language'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                            <?php $__currentLoopData = $main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_key => $main_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="wp-100 wp-sm-50 wp-md-20 main-item py-2">
                                    <a class="dropdown-item"
                                       href="<?php echo e(\App\Helpers\UrlGen::category($main_category)); ?>">
                                        <i class="<?php echo e($main_category->icon_class ?? 'icon-ok'); ?>"></i>
                                        <span class="font-weight-bold">
                                            <?php echo e($main_category->name); ?>

                                        </span>
                                    </a>

                                    <div class="sub-menu">
                                        <?php if(isset($main_category->Subcategories)): ?>
                                            <?php $__currentLoopData = $main_category->Subcategories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_main_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="submenu-item">
                                                    <a class="dropdown-item"
                                                       href="<?php echo e(\App\Helpers\UrlGen::category($sub_main_category, 1)); ?>"><?php echo e($sub_main_category->name); ?></a>
                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="order-3 order-md-2 navigation-special">
                    <?php $__currentLoopData = $main->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item d-inline-flex align-items-center justify-content-center px-2"
                           href="<?php echo e(\App\Helpers\UrlGen::category($main_category)); ?>">
                            <i class="mr-2 <?php echo e($main_category->icon_class ?? 'icon-ok'); ?>"></i>
                            <span class="font-weight-normal"><?php echo e($main_category->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="order-2 order-md-3 category-add">
                    <ul class="nav navbar-nav">
                        <li class="nav-item postadd">
                            <?php if(!auth()->check()): ?>
                                <?php if(config('settings.single.guests_can_post_ads') != '1'): ?>
                                    <a class="btn btn-block btn-border btn-post btn-add-listing" href="#quickLogin"
                                       data-toggle="modal">
                                        
                                        <img src="<?php echo e(asset('images/site/cat.png')); ?>" alt="cat">
                                        <span><?php echo e('RENT'); ?></span>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-block btn-border btn-post btn-add-listing"
                                       href="<?php echo e(\App\Helpers\UrlGen::addPost()); ?>">
                                        
                                        <img src="<?php echo e(asset('images/site/cat.png')); ?>" alt="cat">
                                        <span><?php echo e('RENT'); ?></span>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a class="btn btn-block btn-border btn-post btn-add-listing px-4 py-2"
                                   href="<?php echo e(\App\Helpers\UrlGen::addPost()); ?>">
                                    
                                    <img src="<?php echo e(asset('images/site/cat.png')); ?>" alt="cat" class="img-fluid">
                                    <span><?php echo e('RENT'); ?></span>
                                </a>
                            <?php endif; ?>
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

                

                
                <?php if(auth()->check()): ?>
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
                        <?php $__currentLoopData = $check; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td style="width:14%" class="add-img-td">
                                    <p><?php echo e($ch->user->name); ?></p>
                                </td>
                                <td style="width:58%" class="items-details-td">
                                    <div>
                                        <p>
                                            <strong>
                                                <a href="<?php echo e(\App\Helpers\UrlGen::post($ch->post)); ?>"
                                                   title="<?php echo e($ch->post->title); ?>"><?php echo e($ch->post->title); ?></a>
                                            </strong>
                                        </p>


                                    </div>
                                </td>
                                <td style="width:16%" class="price-td">
                                    <div>
                                        <strong>
                                            Rs.<?php echo e($ch->post->price); ?>

                                        </strong>
                                    </div>
                                </td>
                                <td style="width:10%" class="action-td">
                                    <div>
                                        <p>
                                        <form method="POST" action="<?php echo e(route('messageApprove')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="user_id" value="<?php echo e($ch->user_id); ?>">
                                            <button class="btn btn-primary btn-sm confirm-action" type="submit">
                                                <i class="fa fa-check"></i> Approve
                                            </button>
                                        </form>
                                        </p>
                                        <p>
                                        <form method="POST" action="<?php echo e(route('messageDecline')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($ch->id); ?>">
                                            <button class="btn btn-danger btn-sm delete-action" type="submit"
                                                    onclick="return confirm('Are you sure you want to decline this request?');">
                                                <i class="fa fa-trash"></i> Decline
                                            </button>
                                        </form>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                
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



<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/layouts/inc/header.blade.php ENDPATH**/ ?>