

<?php $__env->startSection('content'); ?>

<style >
  .category-list {
    box-shadow: none;
  }
  .main_profile_img {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.profile_img_data {
    display: flex;
    align-items: center;
}
.img_p_data h2 {
  font-size: 16px;
font-weight: 600;
text-transform: capitalize;
display: block;
margin-bottom: 5px;
padding: 0;
line-height: normal;

}
 span.icon-star-empty {
    color: #ffc32b;
}
 span.icon-star-empty {
    margin-top: 5px;
    font-size: 18px;
    margin-right: -9px;
}
  span.icon-star {
      color: #ffc32b;
      font-size: 14px !important;
  }
  span.icon-star-empty {
      font-size: 14px !important;
      margin-right: 0px !important;
  }
</style>

<div class="container">
    <div class="row">
    <div class="col-md-3">
        <div class="card card-user-info sidebar-card">
            <div class="block-cell user">
                <div class="cell-media">
                    <img src="<?php echo e($user->getPhotoUrlAttribute($user->name)); ?>" alt="<?php echo e($user->getNameAttribute($user->name)); ?>">
                </div>
                <div class="cell-content">
                        <span class="name">
                            <?php if(isset($user) and !empty($user)): ?>
                                <!-- <a href="<?php echo e(\App\Helpers\UrlGen::user($user)); ?>"> -->
                                <!-- <?php echo e($user->id); ?> -->
                                    <a href="<?php echo e(route('profile.details',[$user->id])); ?>">
                                <?php echo e($user->name); ?>

                            </a>
                                <?php else: ?>
                                    <?php echo e($user->name); ?>

                                <?php endif; ?>
                        </span>
                    <?php
                    $tot = 0;
                    $avg = 0;
                    $empty = 0;
                    if($user_reviews->count() > 0){
                        $sum = 0;
                        $tot = $user_reviews->count();
                        foreach($user_reviews as $revie){
                            $sum = $revie->rating + $sum;
                        }
                        $avg = $sum/$tot;
                        $avg = floor($avg);
                    }
                    $empty = 5 - $avg;
                    ?>
                    <div class="main_reviews">
                        <div class="rating">
                            <div class="reviews-widget ratings">
                                <p class="p-0 m-0">
                                    <?php for($i=0; $i<$avg; $i++): ?>
                                        <span class="icon-star "></span>
                                    <?php endfor; ?>
                                    <?php for($i=0; $i<$empty; $i++): ?>
                                        <span class="icon-star-empty "></span>
                                    <?php endfor; ?>
                                    <span class="rating-label d-inline"><small>(<?php echo e($user_reviews->count()); ?>)</small></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="card-body text-left">
                    <div class="grid-col">
                        <div class="col from">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location</span>
                        </div>
                        <div class="col to">
                            <span><?php echo e($user->country_code); ?></span>
                        </div>
                    </div>
                    <div class="grid-col">
                        <div class="col from">
                            <i class="fas fa-user"></i>
                            <span>Joined</span>
                        </div>
                        <div class="col to">
                            <span>
                            <?php
                                $format1 = 'Y-m-d';
                                $format2 = 'H:i:s';
                                $date = Carbon\Carbon::parse($user->created_at)->format($format1);
                                $time = Carbon\Carbon::parse($user->created_at)->format($format2);
                            ?>
                                <?php echo e($date); ?> at <?php echo e($time); ?>

                            </span>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
  <div class="col-md-9 page-content col-thin-left">
     <div class="category-list make-grid">




        <div class="menu-overly-mask"></div>
        <!-- Mobile Filter bar End-->
        <div id="postsList" class="adds-wrapper row no-margin ">
          <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
              // Main Picture
              if ($post->pictures->count() > 0) {
                  $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
              } else {
                  $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
              }
            ?>
           <div class="item-list" style="height: 364px;">
               <?php if($post->featured == 1): ?>
                <div class="cornerRibbons orange">
                   <a href="#"> Premium</a>
                </div>
              <?php endif; ?>
              <div class="row-wrapper cat-wrap">
                 <div class="no-padding photobox mnh-unset mhp-100">
                    <div class="add-image">
                       <div class="fixed-fav d-flex align-items-center">
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
                          <?php if($post->featured == 1): ?>
                            <a class="btn btn-danger btn-sm make-favorite">
                              <i class="fa fa-certificate"></i>
                              <span> Premium </span>
                            </a>&nbsp;
                          <?php endif; ?>
                          <a class="btn btn-default btn-sm make-favorite" id="5">
                          <i class="fa fa-heart"></i><span> Save </span>
                          </a>
                       </div>
                       <a href="<?php echo e(getPostUrl($post)); ?>">
                       <img class="lazyload img-thumbnail no-margin border-0" src="<?php echo e($postImg); ?>" alt="<?php echo e($post->title); ?>">
                       </a>
                    </div>
                 </div>
                 <div class="text-center price-box mt-3" style="white-space: nowrap;">
                    <h4 class="item-price">
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
                 <div class="add-desc-box col-sm-9">
                    <div class="items-details">
                       <h5 class="add-title text-center">
                          <?php echo getPostUrl($post); ?>

                       </h5>
                       <span class="info-row d-flex flex-column align-items-center text-center">
                       <span class="date">
                       <i class="icon-clock"></i> <?php echo e($post->created_at); ?>

                       </span>
                       <span class="category">
                       <i class="icon-folder-circled"></i>&nbsp;
                       <a href="<?php echo e(\App\Helpers\UrlGen::category($post->category)); ?>" class="info-link">
                         <?php echo e($post->category->name); ?>

                       </a>
                       </span>
                       <span class="item-location">
                       <i class="icon-location-2"></i>&nbsp;
                       <?php echo $post->getCityHtml(); ?>

                       </span>
                       </span>
                    </div>
                    <div class="reviews-widget ratings info-row text-center d-flex flex-column">
                      <?php
                      $avg = 0;
                      $empty = 0;
                      if($post->reviews->count() > 0){
                        $sum = 0;
                        $tot = $post->reviews->count();
                        foreach($post->reviews as $revie){
                          $sum = $revie->rating + $sum;
                        }
                        $avg = $sum/$tot;
                        $avg = floor($avg);

                        // dd($avg);
                      }
                      $empty = 5 - $avg;
                       ?>
                       <span class="stars-wrap">
                         <?php for($i=0; $i<$avg; $i++): ?>
                            <span class="icon-star "></span>
                         <?php endfor; ?>
                         <?php for($i=0; $i<$empty; $i++): ?>
                            <span class="icon-star-empty "></span>
                         <?php endfor; ?>

                       </span>
                       <span class="rating-label"><?php echo e($post->reviews->count()); ?> review(s)</span>
                    </div>
                 </div>
              </div>
           </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>There is not any ad(s) available. </p>
         <?php endif; ?>

        </div>
        <hr>
        <?php if($user_reviews): ?>
            <?php $__currentLoopData = $user_reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row comments">
                    <div class="col-md-12">
                        <?php for($i=1; $i <= 5 ; $i++): ?>
                            <span class="icon-star<?php echo e(($i <= $review->rating) ? '' : '-empty'); ?>"></span>
                        <?php endfor; ?>

                        <span class="rating-label">
                            <?php if($review->reviewer_id): ?>
                                <a href="<?php echo e(route('profile.details',[$review->reviewer->id])); ?>">
                                    <?php echo e($review->reviewer->name); ?>

                                </a>
                                ( <?php echo getPostUrl($review->post); ?> )
                            <?php else: ?>
                                <a href="<?php echo e(route('profile.details',[$review->user->id])); ?>">
                                    <?php echo e($review->user->name); ?>

                                </a>
                                on <?php echo getPostUrl($review->post); ?>

                            <?php endif; ?>







                        </span>
                        <br>
                        <br>
                        <span class="pull-right"><?php echo e($review->timeago); ?></span>

                        <p><?php echo $review->comment; ?></p>

                    </div>
                </div>
                <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <nav class="mb-3">
            </nav>

        <?php endif; ?>
        <!-- <h3 class="text-left float-left font-weight-bold">Reviews <small>5 (2)</small></h3>
        <div class="adds-wrapper row no-margin justify-content-center pb-3 ">
           <div class="card mb-3 adds-wrapper row no-margin justify-content-center ">
              <div class="row no-gutters">
                 <div class="col-md-1">
                    <img src="http://rentfirst.ivylabtech.com/images/site/cat.png" height="50px" class="ml-3 mt-3 " alt="...">
                 </div>
                 <div class="col-md-10">
                    <div class="card-body pb-0">
                       <p class="card-text float-right text-right"><small class="text-muted">6 hours ago</small></p>
                       <h5 class="card-title p-0 m-0">Ali Hassan</h5>
                       <p class="card-text p-0 m-0">Aute voluptatibus ut</p>
                       <div class="rating">
                          <div class="reviews-widget ratings text-warning">
                             <p class="p-0 m-0">
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="card mb-3 adds-wrapper row no-margin justify-content-center ">
              <div class="row no-gutters">
                 <div class="col-md-1">
                    <img src="http://rentfirst.ivylabtech.com/images/site/cat.png" height="50px" class="ml-3 mt-3 " alt="...">
                 </div>
                 <div class="col-md-10">
                    <div class="card-body pb-0">
                       <p class="card-text float-right text-right"><small class="text-muted">6 hours ago</small></p>
                       <h5 class="card-title p-0 m-0">Ali Hassan</h5>
                       <p class="card-text p-0 m-0">Aute voluptatibus ut</p>
                       <div class="rating">
                          <div class="reviews-widget ratings text-warning">
                             <p class="p-0 m-0">
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                                <span class="icon-star"></span>
                             </p>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div> -->
     </div>
     <nav class="pagination-bar mb-5 pagination-sm" aria-label="">
     </nav>
  </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/post/profile-details.blade.php ENDPATH**/ ?>