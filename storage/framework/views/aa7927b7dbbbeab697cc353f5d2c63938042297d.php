<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
$hideOnMobile = '';
if (isset($featuredOptions, $featuredOptions['hide_on_mobile']) and $featuredOptions['hide_on_mobile'] == '1') {
    $hideOnMobile = ' hidden-sm';
}
?>
<?php if(isset($featured) and !empty($featured) and $featured->posts->count() > 0): ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container<?php echo e($hideOnMobile); ?>">
        <div class="col-xl-12 content-box layout-section">
            <div class="row row-featured row-featured-category">
                <div class="col-xl-12 box-title">
                    <div class="inner">
                        <h2>
                            <span class="title-3"><?php echo $featured->title; ?></span>

                            <a href="<?php echo e($featured->link); ?>" class="sell-your-item">
                                <?php echo e(t('View more')); ?> <i class="icon-th-list"></i>
                            </a>
                        </h2>
                    </div>
                </div>

                <div style="clear: both"></div>

                <div class="relative content featured-list-row clearfix">

                    <div class="large-12 columns">
                        <div class="no-margin featured-list-slider owl-carousel owl-theme">
                            <?php $__currentLoopData = $featured->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                // Main Picture
                                if ($post->pictures->count() > 0) {
                                    $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                                } else {
                                    $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                                }
                                ?>
                                <div class="item">
                                    <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" class="p-0">
										<span class="item-carousel-thumb">
                                            <span>
                                                <?php if($post->rent): ?>
                                                   <?php $rent_date = strtotime($post->rent->rent_endtime); $today = strtotime(date('Y-m-d h:i A')); ?>
                                                    <?php if($rent_date > $today): ?>
                                                        Unavailable
                                                    <?php else: ?>

                                                        Available
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    Available
                                                <?php endif; ?>
                                            </span>
											<span class="photo-count"><i class="fa fa-camera"></i> <?php echo e($post->pictures->count()); ?> </span>
											<img class="img-fluid" src="<?php echo e($postImg); ?>" alt="<?php echo e($post->title); ?>">
										</span>
                                        <span class="item-carousel-desc px-2">
                                            <span class="price">
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
										    </span>

                                            <h4 class="item-name-wrap"><?php echo e(\Illuminate\Support\Str::limit($post->title, 70)); ?></h4>

                                            <?php if(config('plugins.reviews.installed')): ?>
                                                <?php if(view()->exists('reviews::ratings-list')): ?>
                                                    <?php echo $__env->make('reviews::ratings-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $__env->startSection('after_style'); ?>
    ##parent-placeholder-3cea6eaff3d76a7695a57d7903025a2085e64bfb##
<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_scripts'); ?>
    ##parent-placeholder-094e37d5f5003ce853bb823b74f26393141d779d##
    <script>
        /* Carousel Parameters */
        var carouselItems = <?php echo e((isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0); ?>;
        var carouselAutoplay = <?php echo e((isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false'); ?>;
        var carouselAutoplayTimeout = <?php echo e((isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500); ?>;
        var carouselLang = {
            'navText': {
                'prev': "<?php echo e(t('prev')); ?>",
                'next': "<?php echo e(t('next')); ?>"
            }
        };
    </script>
<?php $__env->stopSection(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/featured.blade.php ENDPATH**/ ?>