<?php if(isset($post) and !empty($post)): ?>
    <?php
    if (!isset($rvPost) || empty($rvPost)) {
        // $rvPost = \extras\plugins\reviews\app\Models\Post::find($post->id);
    }
    ?>
    <?php if(isset($rvPost) and !empty($rvPost)): ?>
        <div class="reviews-widget ratings text-center">
            <?php
            /*
            <p class="pull-right rating-label">{{ $rvPost->rating_count }} {{ trans_choice('reviews::messages.count_reviews', getPlural($rvPost->rating_count)) }}</p>
            */
            ?>
            <p class="d-flex flex-column">
                <span class="stars-wrap">
                    <?php for($i=1; $i <= 5 ; $i++): ?>
                        <span class="icon-star<?php echo e(($i <= $rvPost->rating_cache) ? '' : '-empty'); ?>"></span>
                    <?php endfor; ?>
                </span>
                <span class="rating-label">
                <?php echo e(number_format($rvPost->rating_cache, 1)); ?> <?php echo e(trans_choice('reviews::messages.count_stars', getPlural(number_format($rvPost->rating_cache)))); ?>

                </span>
            </p>
        </div>
    <?php endif; ?>

<?php $__env->startSection('after_styles'); ?>
    ##parent-placeholder-bb86d4c64894d7d4416e528718347e64591a36f9##
    <style>
        .reviews-widget span.icon-star,
        .reviews-widget span.icon-star-empty {
            margin-top: 5px;
            font-size: 18px;
            <?php if(config('lang.direction') == 'rtl'): ?>
           margin-left: -9px;
            <?php else: ?>
           margin-right: -9px;
        <?php endif; ?>
        }

        .reviews-widget .rating-label {
            margin-top: 5px;
            font-size: 16px;
            <?php if(config('lang.direction') == 'rtl'): ?>
           margin-right: 6px;
            <?php else: ?>
           margin-left: 6px;
        <?php endif; ?>











        }

        .reviews-widget span.icon-star,
        .reviews-widget span.icon-star-empty {
            color: #ffc32b;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/extras/plugins/reviews/resources/views/ratings-single.blade.php ENDPATH**/ ?>