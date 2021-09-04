<?php
// Init.
$sForm = [
    'enableFormAreaCustomization' => '0',
    'hideTitles' => '0',
    'title' => t('sell_and_buy_near_you'),
    'subTitle' => t('simple_fast_and_efficient'),
    'bigTitleColor' => '', // 'color: #FFF;',
    'subTitleColor' => '', // 'color: #FFF;',
    'backgroundColor' => '', // 'background-color: #444;',
    'backgroundImage' => '', // null,
    'height' => '', // '450px',
    'parallax' => '0',
    'hideForm' => '0',
    'formBorderColor' => '', // 'background-color: #333;',
    'formBorderSize' => '', // '5px',
    'formBtnBackgroundColor' => '', // 'background-color: #4682B4; border-color: #4682B4;',
    'formBtnTextColor' => '', // 'color: #FFF;',
];

// Get Search Form Options
if (isset($searchFormOptions)) {
    if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
        $sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
    }
    if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
        $sForm['hideTitles'] = $searchFormOptions['hide_titles'];
    }
    if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
        $sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
        $sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
        if (\Illuminate\Support\Str::contains($sForm['title'], '{count_ads}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['title'] = str_replace('{count_ads}', $countPosts, $sForm['title']);
        }
        if (\Illuminate\Support\Str::contains($sForm['title'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
        }
    }
    if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
        $sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
        $sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
        if (\Illuminate\Support\Str::contains($sForm['subTitle'], '{count_ads}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['subTitle'] = str_replace('{count_ads}', $countPosts, $sForm['subTitle']);
        }
        if (\Illuminate\Support\Str::contains($sForm['subTitle'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
        }
    }
    if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
        $sForm['parallax'] = $searchFormOptions['parallax'];
    }
    if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
        $sForm['hideForm'] = $searchFormOptions['hide_form'];
    }
}

// Country Map status (shown/hidden)
$showMap = false;
if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
    if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
        $showMap = true;
    }
}
$hideOnMobile = '';
if (isset($searchFormOptions, $searchFormOptions['hide_on_mobile']) and $searchFormOptions['hide_on_mobile'] == '1') {
    $hideOnMobile = ' hidden-sm';
}
?>
<?php if(isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1'): ?>

    <?php if(isset($firstSection) and !$firstSection): ?>
        <div class="h-spacer"></div>
    <?php endif; ?>

    <?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
    <div class="wide-intro <?php echo e($parallax); ?><?php echo e($hideOnMobile); ?>">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container text-center">

                    <?php if($sForm['hideTitles'] != '1'): ?>
                        <h1 class="intro-title animated fadeInDown"> <?php echo e($sForm['title']); ?> </h1>
                        <p class="sub animateme fittext3 animated fadeIn">
                            <?php echo $sForm['subTitle']; ?>

                        </p>
                    <?php endif; ?>

                    <?php if($sForm['hideForm'] != '1'): ?>
                        <div class="search-row animated fadeInUp rounded">
                            <form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::search()); ?>" method="GET">

                                <div class="row m-0 justify-content-center justify-content-md-around">
                                    <div class="col-md-5 col-12 search-col relative locationicon search-location">
                                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                                            <i class="far fa-map-marker-alt"></i>
                                            <input type="hidden" id="lSearch" name="l" value="">
                                            <?php if($showMap): ?>
                                                <label for="locSearch" class="sr-only"></label>
                                                <input type="text" id="locSearch" name="location"
                                                       class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                                       placeholder="<?php echo e(t('where')); ?>" value="" title=""
                                                       data-placement="bottom" data-toggle="tooltip"
                                                       data-original-title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>">
                                            <?php else: ?>
                                                <label for="locSearch" class="sr-only"></label>
                                                <input type="text" id="locSearch" name="location" value=""
                                                       class="form-control locinput input-rel searchtag-input has-icon"
                                                       placeholder="<?php echo e(t('where')); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-5 col-12 search-col relative search-keyword">
                                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                                            <i class="far fa-search"></i>
                                            <label for="keyword" class="sr-only"></label>
                                            <input type="text" name="q" id="keyword" value=""
                                                   class="form-control keyword has-icon" placeholder="<?php echo e(t('what')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12 search-col search-button">
                                        <div class="mt-md-0 px-2 w-100 position-relative d-flex align-items-center justify-content-center justify-content-md-start">
                                            <button class="btn btn-primary btn-search btn-block">
                                                <i class="icon-search"></i> <strong><?php echo e(t('find')); ?></strong>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container">
        <div class="intro rounded">
            <div class="dtable hw100">
                <div class="dtable-cell hw100">
                    <div class="container text-center">

                        <div class="search-row fadeInUp">
                            <form id="search" name="search" action="<?php echo e(\App\Helpers\UrlGen::search()); ?>" method="GET">
                                <div class="row m-0">

                                    <div class="col-md-5 col-12 search-col search-location relative locationicon">
                                        <i class="icon-location-2 icon-append"></i>
                                        <input type="hidden" id="lSearch" name="l" value="">
                                        <?php if($showMap): ?>
                                            <input type="text" id="locSearch" name="location"
                                                   class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                                   placeholder="<?php echo e(t('where')); ?>" value="" title=""
                                                   data-placement="bottom"
                                                   data-toggle="tooltip" type="button"
                                                   data-original-title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>">
                                        <?php else: ?>
                                            <input type="text" id="locSearch" name="location"
                                                   class="form-control locinput input-rel searchtag-input has-icon"
                                                   placeholder="<?php echo e(t('where')); ?>" value="">
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-5 col-12 mb-1 mb-md-0 search-col search-keyword relative">
                                        <i class="icon-docs icon-append"></i>
                                        <input type="text" name="q" class="form-control keyword has-icon"
                                               placeholder="<?php echo e(t('what')); ?>" value="">
                                    </div>

                                    <div class="col-md-2 search-col search-button">
                                        <button class="btn btn-primary btn-search btn-block">
                                            <i class="icon-search"></i> <strong><?php echo e(t('find')); ?></strong>
                                        </button>
                                    </div>
                                    <?php echo csrf_field(); ?>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/search.blade.php ENDPATH**/ ?>