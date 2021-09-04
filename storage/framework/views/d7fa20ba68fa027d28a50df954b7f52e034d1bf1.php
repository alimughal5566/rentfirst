<?php
$hideOnMobile = '';
if (isset($statsOptions, $statsOptions['hide_on_mobile']) and $statsOptions['hide_on_mobile'] == '1') {
    $hideOnMobile = ' hidden-sm';
}
?>
<?php if(isset($countPosts) and isset($countUsers) and isset($countCities)): ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="<?php echo e($hideOnMobile); ?>">
        <div class="page-info page-info-lite rounded">
            <div class="text-center section-promo">
                <div class="row">

                    <?php if(isset($countPosts)): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="iconbox-wrap">
                                <div class="iconbox">
                                    <div class="iconbox-wrap-icon">
                                        <i class="icon icon-docs"></i>
                                    </div>
                                    <div class="iconbox-wrap-content">
                                        <h5><span><?php echo e($countPosts); ?></span></h5>
                                        <div class="iconbox-wrap-text"><?php echo e(t('free_ads')); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($countUsers)): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="iconbox-wrap">
                                <div class="iconbox">
                                    <div class="iconbox-wrap-icon">
                                        <i class="icon icon-group"></i>
                                    </div>
                                    <div class="iconbox-wrap-content">
                                        <h5><span><?php echo e($countUsers); ?></span></h5>
                                        <div class="iconbox-wrap-text"><?php echo e(t('Trusted Sellers')); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($countCities)): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="iconbox-wrap">
                                <div class="iconbox">
                                    <div class="iconbox-wrap-icon">
                                        <i class="icon icon-map"></i>
                                    </div>
                                    <div class="iconbox-wrap-content">
                                        <h5><span><?php echo e($countCities . '+'); ?></span></h5>
                                        <div class="iconbox-wrap-text"><?php echo e(t('locations')); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/stats.blade.php ENDPATH**/ ?>