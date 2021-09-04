<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
?>
<?php if(isset($posts) && $posts->total() > 0): ?>
    <?php
    if (!isset($cats)) {
        $cats = collect([]);
    }

    foreach($posts->items() as $key => $post):
    if (empty($post->city)) continue;

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

        <div class="row-wrapper cat-wrap">
            <div class="no-padding photobox mnh-unset mhp-100">
                <div class="add-image">
                    <div class="fixed-fav d-flex align-items-center">
                        <span class="photo-count"><i class="fa fa-camera"></i> <?php echo e($post->pictures->count()); ?> </span>
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
                            <a class="btn btn-default btn-sm make-favorite" id="<?php echo e($post->id); ?>">
                                <i class="fa fa-heart"></i><span> <?php echo e(t('Save')); ?> </span>
                            </a>
                        <?php endif; ?>

                    </div>
                    <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>">
                        <img class="lazyload img-thumbnail no-margin border-0" src="<?php echo e($postImg); ?>"
                             alt="<?php echo e($post->title); ?>">
                    </a>
                </div>
            </div>

            <div class="text-center price-box mt-3" style="white-space: nowrap;">
                <h4 class="item-price">
                    <?php if(isset($post->category->type)): ?>
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
                        <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>"><?php echo e(\Illuminate\Support\Str::limit($post->title, 70)); ?> </a>
                    </h5>

                    <span class="info-row d-flex flex-column align-items-center text-center">
						<?php if(isset($post->postType) && !empty($post->postType)): ?>
                            <span class="add-type business-ads tooltipHere"
                                  data-toggle="tooltip"
                                  data-placement="bottom"
                                  title="<?php echo e($post->postType->name); ?>"
                            >
								<?php echo e(strtoupper(mb_substr($post->postType->name, 0, 1))); ?>

							</span>&nbsp;
                        <?php endif; ?>
                        <?php if(!config('settings.listing.hide_dates')): ?>
                            <span class="date"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
								<i class="icon-clock"></i> <?php echo $post->created_at_formatted; ?>

							</span>
                        <?php endif; ?>
						<span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
							<i class="icon-folder-circled"></i>&nbsp;
							<?php if(isset($post->category->parent) && !empty($post->category->parent)): ?>
                                <a href="<?php echo \App\Helpers\UrlGen::category($post->category->parent, null, $city ?? null); ?>"
                                   class="info-link">
									<?php echo e($post->category->parent->name); ?>

								</a>&nbsp;&raquo;&nbsp;
                            <?php endif; ?>
							<a href="<?php echo \App\Helpers\UrlGen::category($post->category, null, $city ?? null); ?>"
                               class="info-link">
								<?php echo e($post->category->name); ?>

							</a>
						</span>
						<span class="item-location"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
							<i class="icon-location-2"></i>&nbsp;
							<a href="<?php echo \App\Helpers\UrlGen::city($post->city, null, $cat ?? null); ?>"
                               class="info-link">
								<?php echo e($post->city->name); ?>

							</a> <?php echo e((isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : ''); ?>

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
    <?php endforeach; ?>
<?php else: ?>
    <div class="p-4" style="width: 100%;">
        <?php echo e(t('no_result_refine_your_search')); ?>

    </div>
<?php endif; ?>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
    <script>
        /* Default view (See in /js/script.js) */
        <?php if($count->get('all') > 0): ?>
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
<?php $__env->stopSection(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/search/inc/posts.blade.php ENDPATH**/ ?>