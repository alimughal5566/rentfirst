<!-- City -->
<div class="block-title has-arrow sidebar-header">
    <h5>
		<span class="font-weight-bold">
			<?php echo e(t('locations')); ?>

		</span>
    </h5>
</div>
<div class="block-content list-filter locations-list">
    <ul class="browse-list list-unstyled long-list">
        <?php if(isset($cities) && $cities->count() > 0): ?>
            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <?php if((isset($city) && !empty($city) && $city->id == $iCity->id) || (request()->input('l') == $iCity->id)): ?>
                        <strong>
                            <a href="<?php echo \App\Helpers\UrlGen::city($iCity, null, $cat ?? null); ?>"
                               title="<?php echo e($iCity->name); ?>">
                                <?php echo e($iCity->name); ?>

                                <?php if(config('settings.listing.count_cities_posts')): ?>
                                    <span class="count"><?php echo e($iCity->posts_count ?? 0); ?></span>
                                <?php endif; ?>
                            </a>
                        </strong>
                    <?php else: ?>
                        <a href="<?php echo \App\Helpers\UrlGen::city($iCity, null, $cat ?? null); ?>"
                           title="<?php echo e($iCity->name); ?>">
                            <?php echo e($iCity->name); ?>

                            <?php if(config('settings.listing.count_cities_posts')): ?>
                                <span class="count"><?php echo e($iCity->posts_count ?? 0); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</div>
<div style="clear:both"></div><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/search/inc/sidebar/cities.blade.php ENDPATH**/ ?>