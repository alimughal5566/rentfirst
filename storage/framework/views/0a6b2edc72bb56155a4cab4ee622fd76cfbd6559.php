<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
if (config('settings.listing.display_mode') == '.compact-view') {
    $colDescBox = 'col-sm-9 col-12';
    $colPriceBox = 'col-sm-3 col-12';
} else {
    $colDescBox = 'col-sm-7 col-12';
    $colPriceBox = 'col-sm-3 col-12';
}
$hideOnMobile = '';
if (isset($latestOptions, $latestOptions['hide_on_mobile']) and $latestOptions['hide_on_mobile'] == '1') {
    $hideOnMobile = ' hidden-sm';
}
?>
<?php if(isset($latest) && !empty($latest) && $latest->posts->count() > 0): ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container<?php echo e($hideOnMobile); ?>">
        <div class="col-xl-12 content-box layout-section">
            <div class="row row-featured row-featured-category">

                <div class="col-xl-12 box-title no-border">
                    <div class="inner">
                        <h2>
                            <span class="title-3"><?php echo $latest->title; ?></span>
                            <a href="<?php echo e($latest->link); ?>" class="sell-your-item">
                                <?php echo e(t('View more')); ?> <i class="icon-th-list"></i>
                            </a>
                        </h2>
                    </div>
                </div>

                <div id="postsList" class="adds-wrapper noSideBar category-list pt-3">
                    <?php $__currentLoopData = $latest->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(empty($post->city)) continue; ?>
                        <?php
                        // Main Picture
                        if ($post->pictures->count() > 0) {
                            $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                        } else {
                            $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                        }
                        ?>
                        <div class="item-list">
                            <?php if($post->featured == 1): ?>
                                <?php if(isset($post->latestPayment, $post->latestPayment->package) && !empty($post->latestPayment->package)): ?>
                                    <?php if($post->latestPayment->package->ribbon != ''): ?>
                                        <div class="cornerRibbons <?php echo e($post->latestPayment->package->ribbon); ?>">
                                            <a href="#"> <?php echo e($post->latestPayment->package->short_name); ?></a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="row-wrapper">
                                <div class="no-padding photobox">
                                    <div class="add-image">
                                        <div class="fixed-fav d-flex align-items-center">
                                            <?php if(isset($post->latestPayment, $post->latestPayment->package) && !empty($post->latestPayment->package)): ?>
                                                <?php if($post->latestPayment->package->has_badge == 1): ?>
                                                    <a class="btn btn-danger btn-sm make-favorite">
                                                        <i class="fa fa-certificate"></i>
                                                        <span> <?php echo e($post->latestPayment->package->short_name); ?> </span>
                                                    </a>&nbsp;
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(isset($post->savedByLoggedUser) && $post->savedByLoggedUser->count() > 0): ?>
                                                <a class="btn btn-success btn-sm make-favorite" id="<?php echo e($post->id); ?>">
                                                    <i class="fa fa-heart"></i><span> <?php echo e(t('Saved')); ?> </span>
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-default btn-sm make-favorite mx-2"
                                                   id="<?php echo e($post->id); ?>">
                                                    <i class="fa fa-heart"></i><span> <?php echo e(t('Save')); ?> </span>
                                                </a>
                                            <?php endif; ?>
                                            <span class="photo-count position-unset"><i class="fa fa-camera"></i> <?php echo e($post->pictures->count()); ?> </span>
                                        </div>

                                        <a class="img-wrap" href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
                                            <img class="lazyload img-thumbnail no-margin border-0" src="<?php echo e($postImg); ?>"
                                                 alt="<?php echo e($post->title); ?>">
                                        </a>
                                        <?php if(isset($post->rent)): ?>
                                            <h5 class="mt-3 tick_time" data-date="<?php echo e($post->rent->rent_endtime); ?>"
                                                id="timer_<?php echo e($post->rent->id); ?>">
                                                
                                                <span class="days"></span>
                                                <span class="hours"></span>
                                                <span class="minutes"></span>
                                                <span class="seconds"></span>
                                            </h5>

                                            <script>
                                                document.addEventListener('readystatechange', event => {
                                                    if (event.target.readyState === "complete") {
                                                        var clockdiv = document.getElementsByClassName("tick_time");
                                                        var countDownDate = new Array();
                                                        for (var i = 0; i < clockdiv.length; i++) {
                                                            countDownDate[i] = new Array();
                                                            countDownDate[i]['el'] = clockdiv[i];
                                                            countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                                                            countDownDate[i]['days'] = 0;
                                                            countDownDate[i]['hours'] = 0;
                                                            countDownDate[i]['seconds'] = 0;
                                                            countDownDate[i]['minutes'] = 0;
                                                        }

                                                        var countdownfunction = setInterval(function () {
                                                            for (var i = 0; i < countDownDate.length; i++) {
                                                                var now = new Date().getTime();
                                                                var distance = countDownDate[i]['time'] - now;
                                                                countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

                                                                if (distance < 0) {
                                                                    countDownDate[i]['el'].querySelector('.days').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.hours').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = "";
                                                                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = "";
                                                                } else {
                                                                    countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'] + 'd';
                                                                    countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'] + 'h';
                                                                    countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'] + 'm';
                                                                    countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'] + 's';
                                                                }

                                                            }
                                                        }, 1000);
                                                    }
                                                });
                                            </script>
                                        <?php endif; ?>

                                    </div>
                                </div>

                                <div class="price-box mt-3">
                                    <h4 class="item-price pb-0 text-center d-flex align-items-center justify-content-center">
                                        <?php if(isset($post->category, $post->category->type)): ?>
                                            <?php if(!in_array($post->category->type, ['not-salable'])): ?>
                                                <?php if(is_numeric($post->price) && $post->price > 0): ?>
                                                    <?php echo \App\Helpers\Number::money($post->price); ?>

                                                <?php elseif(is_numeric($post->price) && $post->price == 0): ?>
                                                    <?php echo t('free_as_price'); ?>

                                                <?php else: ?>
                                                    <?php echo \App\Helpers\Number::money(' --'); ?>

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo e('--'); ?>

                                        <?php endif; ?>
                                    </h4>
                                </div>

                                <div class="add-desc-box">
                                    <div class="items-details">
                                        <h5 class="add-title text-center">
                                            <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>"><?php echo e(\Illuminate\Support\Str::limit($post->title, 70)); ?></a>
                                        </h5>

                                        <span class="info-row d-flex flex-column align-items-center text-center">
											<?php if(isset($post->postType) && !empty($post->postType)): ?>
                                                <span class="add-type business-ads tooltipHere"
                                                      data-toggle="tooltip" data-placement="bottom"
                                                      title="<?php echo e($post->postType->name); ?>">
													<?php echo e(strtoupper(mb_substr($post->postType->name, 0, 1))); ?>

												</span>&nbsp;
                                            <?php endif; ?>
                                            <?php if(!config('settings.listing.hide_dates')): ?>
                                                <span class="date">
													<i class="icon-clock"></i> <?php echo $post->created_at_formatted; ?>

												</span>
                                            <?php endif; ?>
											<span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
												<i class="icon-folder-circled"></i>&nbsp;
												<?php if(isset($post->category->parent) && !empty($post->category->parent)): ?>
                                                    <a href="<?php echo \App\Helpers\UrlGen::category($post->category->parent); ?>"
                                                       class="info-link">
														<?php echo e($post->category->parent->name); ?>

													</a>&nbsp;&raquo;&nbsp;
                                                <?php endif; ?>
												<a href="<?php echo \App\Helpers\UrlGen::category($post->category); ?>"
                                                   class="info-link">
													<?php echo e($post->category->name); ?>

												</a>
											</span>
											<span class="item-location"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
												<i class="icon-location-2"></i>&nbsp;
												<a href="<?php echo \App\Helpers\UrlGen::city($post->city); ?>"
                                                   class="info-link">
													<?php echo e($post->city->name); ?>

												</a>
												<?php echo e((isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : ''); ?>

											</span>
										</span>
                                    </div>

                                    <?php if(config('plugins.reviews.installed')): ?>
                                        <?php if(view()->exists('reviews::ratings-list')): ?>
                                            <?php echo $__env->make('reviews::ratings-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div style="clear: both"></div>

                    <?php if(isset($latestOptions) && isset($latestOptions['show_view_more_btn']) && $latestOptions['show_view_more_btn'] == '1'): ?>
                        <div class="mt10 mb10 text-center wp-100 load-more">
                            <a href="<?php echo e(\App\Helpers\UrlGen::search()); ?>" class="btn btn-default mt10 px-4 px-md-5">
                                
                                <?php echo e('Load more'); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
    <script>
        /* Default view (See in /js/script.js) */
        <?php if(isset($posts) && count($posts) > 0): ?>
        <?php if(config('settings.listing.display_mode') == '.grid-view'): ?>
        gridView('.grid-view');
        <?php elseif(config('settings.listing.display_mode') == '.list-view'): ?>
        listView('.list-view');
        <?php elseif(config('settings.listing.display_mode') == '.compact-view'): ?>
        compactView('.compact-view');
        <?php else: ?>
        gridView('.grid-view');
        <?php endif; ?>
        <?php else: ?>
        listView('.list-view');
        <?php endif; ?>
        /* Save the Search page display mode */
        var listingDisplayMode = readCookie('listing_display_mode');
        if (!listingDisplayMode) {
            createCookie('listing_display_mode', '<?php echo e(config('settings.listing.display_mode', '.grid-view')); ?>', 7);
        }

        /* Favorites Translation */
        var lang = {
            labelSavePostSave: "<?php echo t('Save ad'); ?>",
            labelSavePostRemove: "<?php echo t('Remove favorite'); ?>",
            loginToSavePost: "<?php echo t('Please log in to save the Ads'); ?>",
            loginToSaveSearch: "<?php echo t('Please log in to save your search'); ?>",
            confirmationSavePost: "<?php echo t('Post saved in favorites successfully'); ?>",
            confirmationRemoveSavePost: "<?php echo t('Post deleted from favorites successfully'); ?>",
            confirmationSaveSearch: "<?php echo t('Search saved successfully'); ?>",
            confirmationRemoveSaveSearch: "<?php echo t('Search deleted successfully'); ?>"
        };
    </script>

<?php $__env->stopSection(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/latest.blade.php ENDPATH**/ ?>