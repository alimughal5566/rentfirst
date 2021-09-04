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
                
                <a href="<?php echo e(url('/')); ?>" class="navbar-brand logo logo-title">
                    <img src="<?php echo e(imgUrl(config('settings.app.logo', config('larapen.core.logo')), 'logo')); ?>"
                         class="tooltipHere main-logo"/>
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
                                    <img src="<?php echo e(url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion()); ?>"
                                         alt="<?php echo e(config('country.name')); ?>"
                                         style="float: left;"
                                    >
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
                                        data-placement="<?php echo e((config('lang.direction') == 'rtl') ? 'bottom' : 'right'); ?>">
                                        <?php if(isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled): ?>
                                            <a href="#selectCountry" data-toggle="modal" class="nav-link">
                                                <img class="flag-icon" alt="<?php echo e(config('country.name')); ?>"
                                                     src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>">
                                                <span class="caret hidden-sm"></span>
                                            </a>
                                        <?php else: ?>
                                            <a style="cursor: default;">
                                                <img class="flag-icon no-caret" alt="<?php echo e(config('country.name')); ?>"
                                                     src="<?php echo e(url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion()); ?>">
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <ul class="nav navbar-nav ml-auto navbar-right">
                    <?php if(!auth()->check()): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link">
                                <i class="icon-user fa"></i> <?php echo e(t('log_in')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(\App\Helpers\UrlGen::login()); ?>" class="nav-link">
                                <i class="icon-user-add fa"></i> <?php echo e(t('register')); ?>

                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <?php if(app('impersonate')->isImpersonating()): ?>
                                <a href="<?php echo e(route('impersonate.leave')); ?>" class="nav-link">
                                    <i class="icon-logout hidden-sm"></i> <?php echo e(t('Leave')); ?>

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(\App\Helpers\UrlGen::logout()); ?>" class="nav-link">
                                    <i class="glyphicon glyphicon-off"></i> <?php echo e(t('log_out')); ?>

                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="icon-user fa hidden-sm"></i>
                                <span><?php echo e(auth()->user()->name); ?></span>
                                <i class="icon-down-open-big fa"></i>
                            </a>
                            <ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">
                                <li class="dropdown-item active">
                                    <a href="<?php echo e(url('account')); ?>">
                                        <i class="icon-home"></i> <?php echo e(t('Personal Home')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/my-posts')); ?>">
                                        <i class="icon-th-thumb"></i> <?php echo e(t('my_ads')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/favourite')); ?>">
                                        <i class="icon-heart"></i> <?php echo e(t('favourite_ads')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/saved-search')); ?>">
                                        <i class="icon-star-circled"></i> <?php echo e(t('Saved searches')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/pending-approval')); ?>">
                                        <i class="icon-hourglass"></i> <?php echo e(t('pending_approval')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/archived')); ?>">
                                        <i class="icon-folder-close"></i> <?php echo e(t('archived_ads')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/messages')); ?>">
                                        <i class="icon-mail-1"></i> <?php echo e(t('messenger')); ?>

                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo e(url('account/transactions')); ?>">
                                        <i class="icon-money"></i> <?php echo e(t('Transactions')); ?>

                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>






















                    <?php if(!empty(config('lang.abbr'))): ?>
                        <?php if(is_array(getSupportedLanguages()) && count(getSupportedLanguages()) > 1): ?>
                        <!-- Language selector -->
                            <li class="dropdown lang-menu nav-item">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                    <span class="lang-title"><?php echo e(strtoupper(config('app.locale'))); ?></span>
                                </button>
                                <ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm"
                                    role="menu">
                                    <?php $__currentLoopData = getSupportedLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langCode => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(strtolower($langCode) == strtolower(config('app.locale'))) continue; ?>
                                        <li class="dropdown-item">
                                            <a href="<?php echo e(url('lang/' . $langCode)); ?>" tabindex="-1" rel="alternate"
                                               hreflang="<?php echo e($langCode); ?>">
                                                <span class="lang-name"><?php echo e($lang['native']); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
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
                            <?php if(isset($main)): ?>
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="order-3 order-md-2 navigation-special">
                    <?php if(isset($main)): ?>
                    <?php $__currentLoopData = $main->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item d-inline-flex align-items-center justify-content-center px-2"
                           href="<?php echo e(\App\Helpers\UrlGen::category($main_category)); ?>">
                            <i class="mr-2 <?php echo e($main_category->icon_class ?? 'icon-ok'); ?>"></i>
                            <span class="font-weight-normal"><?php echo e($main_category->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
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
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/errors/layouts/inc/header.blade.php ENDPATH**/ ?>