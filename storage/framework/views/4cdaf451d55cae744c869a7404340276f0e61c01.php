<?php if(isset($post) and !empty($post)): ?>
    <?php
    $rvPost = \extras\plugins\reviews\app\Models\Post::find($post->id);
    ?>
    <?php if(isset($rvPost) and !empty($rvPost)): ?>
        <div class="reviews-widget ratings info-row text-center d-flex flex-column">
            <span class="stars-wrap">
                <?php for($i=1; $i <= 5 ; $i++): ?>
                    <span class="icon-star<?php echo e(($i <= $rvPost->rating_cache) ? '' : '-empty'); ?>"></span>
                <?php endfor; ?>
            </span>
            <span class="rating-label"><?php echo e($rvPost->rating_count); ?> <?php echo e(trans_choice('reviews::messages.count_reviews', getPlural($rvPost->rating_count))); ?></span>
        </div>
    <?php endif; ?>

<?php $__env->startSection('reviews_styles'); ?>
    <style>
        .reviews-widget > span.icon-star,
        .reviews-widget > span.icon-star-empty {
            margin-top: 5px;
            font-size: 16px;
            <?php if(config('lang.direction') == 'rtl'): ?>
                  margin-left: -8px;
            <?php else: ?>
                  margin-right: -8px;
        <?php endif; ?>



        }

        .reviews-widget > span.rating-label {
            margin-top: 5px;
            font-size: 14px;
            <?php if(config('lang.direction') == 'rtl'): ?>
                  margin-right: 4px;
            <?php else: ?>
                  margin-left: 4px;
        <?php endif; ?>



        }

        .reviews-widget > span.icon-star,
        .reviews-widget > span.icon-star-empty {
            color: #ffc32b;
        }

        .featured-list-slider span {
            display: inline;
        }

        .featured-list-slider .reviews-widget > span.icon-star,
        .featured-list-slider .reviews-widget > span.icon-star-empty {
            margin-top: 5px;
            font-size: 16px;
            <?php if(config('lang.direction') == 'rtl'): ?>
                  margin-left: -8px;
            <?php else: ?>
                  margin-right: -8px;
        <?php endif; ?>



        }

        .featured-list-slider .reviews-widget > span.rating-label {
            margin-top: 5px;
            font-size: 12px;
            <?php if(config('lang.direction') == 'rtl'): ?>
                  margin-right: 4px;
            <?php else: ?>
                  margin-left: 4px;
        <?php endif; ?>


        }
    </style>
<?php $__env->stopSection(); ?>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/extras/plugins/reviews/resources/views/ratings-list.blade.php ENDPATH**/ ?>