

<?php $__env->startSection('content'); ?>
<script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>

<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

<style>
.carousel-container {
  position: relative;
}
.carousel-item img {
  object-fit: cover;
}
#carousel-thumbs {
  background: rgba(255,255,255,.3);
  bottom: 0;
  left: 0;
  padding: 0 50px;
  position: absolute;
  right: 0;
}
#carousel-thumbs img {
  border: 5px solid transparent;
  cursor: pointer;
}
#carousel-thumbs img:hover {
  border-color: rgba(255,255,255,.3);
}
#carousel-thumbs .selected img {
  border-color: #fff;
}
.carousel-control-prev,
.carousel-control-next {
  width: 50px;
}

</style>


    <?php echo csrf_field(); ?>

    <input type="hidden" id="postId" name="post_id" value="<?php echo e($post->id); ?>">

    <?php if(Session::has('flash_notification')): ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php $paddingTopExists = true; ?>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php Session::forget('flash_notification.message'); ?>
    <?php endif; ?>

    <div class="main-container">

        <?php if (\App\Models\Advertising::where('slug', 'top')->count() > 0): ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top', 'layouts.inc.advertising.top'], ['paddingTopExists' => (isset($paddingTopExists)) ? $paddingTopExists : false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php
        $paddingTopExists = false;
    endif;
    ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <nav aria-label="breadcrumb" role="navigation" class="pull-left">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><i class="icon-home fa"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(config('country.name')); ?></a></li>
                            <?php if(isset($catBreadcrumb) and is_array($catBreadcrumb) and count($catBreadcrumb) > 0): ?>
                                <?php $__currentLoopData = $catBreadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e($value->get('url')); ?>">
                                            <?php echo $value->get('name'); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <li class="breadcrumb-item active"
                                aria-current="page"><?php echo e(\Illuminate\Support\Str::limit($post->title, 70)); ?></li>
                        </ol>
                    </nav>

                    <div class="pull-right backtolist">
                        <a href="<?php echo e(rawurldecode(url()->previous())); ?>">
                            <i class="fa fa-angle-double-left"></i> <?php echo e(t('back_to_results')); ?></a>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 page-content col-thin-right">
                    <div class="inner inner-box items-details-wrapper pb-0">
                        <h2 class="enable-long-words">
                            <strong>
                                <a href="<?php echo e(\App\Helpers\UrlGen::post($post)); ?>" title="<?php echo e($post->title); ?>">
                                    <?php echo e($post->title); ?>

                                </a>
                            </strong>
                            <?php if(isset($post->postType) and !empty($post->postType)): ?>
                                <small class="label label-default adlistingtype"><?php echo e($post->postType->name); ?></small>
                            <?php endif; ?>
                            <?php if($post->featured==1 and !empty($post->latestPayment)): ?>
                                <?php if(isset($post->latestPayment->package) and !empty($post->latestPayment->package)): ?>
                                    <i class="icon-ok-circled tooltipHere"
                                       style="color: <?php echo e($post->latestPayment->package->ribbon); ?>;" title=""
                                       data-placement="bottom" data-toggle="tooltip"
                                       data-original-title="<?php echo e($post->latestPayment->package->short_name); ?>"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </h2>

<?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>
                        <div class="container">
      <div class="carousel-container row">

      <!-- Sorry! Lightbox doesn't work - yet. -->

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php if(count($post->pictures) > 0): ?>
            <?php $__currentLoopData = $post->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($key == 0): ?>
                <div class="carousel-item active" data-slide-number="<?php echo e($key); ?>">
                  <img src="<?php echo e(imgUrl($image->filename)); ?>" class="d-block w-100"  alt="<?php echo e($titleSlug); ?> " data-remote="<?php echo e(imgUrl($image->filename)); ?>" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                </div>
              <?php else: ?>
                <div class="carousel-item " data-slide-number="<?php echo e($key); ?>">
                  <img src="<?php echo e(imgUrl($image->filename)); ?>" class="d-block w-100" alt="<?php echo e($titleSlug); ?>" data-remote="<?php echo e(imgUrl($image->filename)); ?>" data-type="image" data-toggle="lightbox" data-gallery="example-gallery">
                </div>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>
      </div>

      <!-- Carousel Navigation -->
      <div id="carousel-thumbs" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row mx-0">
              <?php if(count($post->pictures) > 0): ?>
                <?php $__currentLoopData = $post->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($key < 6): ?>
                    <div id="carousel-selector-<?php echo e($key); ?>" class="thumb col-2 px-1 py-2 <?php echo e($key == 0 ? 'selected' : ''); ?>" data-target="#myCarousel" data-slide-to="0">
                      <img src="<?php echo e(imgUrl($image->filename)); ?>" class="img-fluid" alt="">
                    </div>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
          </div>
          <?php if(count($post->pictures)>6): ?>
          <div class="carousel-item">
            <div class="row mx-0">
              <?php if(count($post->pictures) > 0): ?>
                <?php $__currentLoopData = $post->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($key > 5): ?>
                    <div id="carousel-selector-<?php echo e($key); ?>" class="thumb col-2 px-1 py-2 <?php echo e($key == 0 ? 'selected' : ''); ?>" data-target="#myCarousel" data-slide-to="0">
                      <img src="<?php echo e(imgUrl($image->filename)); ?>" class="img-fluid" alt="">
                    </div>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
              <div class="col-2 px-1 py-2"></div>
              <div class="col-2 px-1 py-2"></div>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      </div> <!-- /row -->
      </div> <!-- /container -->



                        <!-- <div class="posts-image">
                            <?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>

                            <?php if(count($post->pictures) > 0): ?>
                                <ul class="bxslider">
                                    <?php $__currentLoopData = $post->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <img src="<?php echo e(imgUrl($image->filename, 'big')); ?>"
                                                 alt="<?php echo e($titleSlug . '-big-' . $key); ?>">
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="product-view-thumb-wrapper">
                                    <ul id="bx-pager" class="product-view-thumb">
                                        <?php $__currentLoopData = $post->pictures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <a class="thumb-item-link" data-slide-index="<?php echo e($key); ?>" href="">
                                                    <img src="<?php echo e(imgUrl($image->filename, 'small')); ?>"
                                                         alt="<?php echo e($titleSlug . '-small-' . $key); ?>">
                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <ul class="bxslider">
                                    <li>
                                        <img src="<?php echo e(imgUrl(config('larapen.core.picture.default'), 'big')); ?>"
                                             alt="img">
                                    </li>
                                </ul>
                                <div class="product-view-thumb-wrapper">
                                    <ul id="bx-pager" class="product-view-thumb">
                                        <li>
                                            <a class="thumb-item-link" data-slide-index="0" href="">
                                                <img src="<?php echo e(imgUrl(config('larapen.core.picture.default'), 'small')); ?>"
                                                     alt="img">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div> -->
                        <!--posts-image-->

                        <div class="items-details">
                            <ul class="nav nav-tabs" id="itemsDetailsTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="item-details-tab" data-toggle="tab"
                                       href="#item-details" role="tab" aria-controls="item-details"
                                       aria-selected="true">
                                        <h4><?php echo e(t('ad_details')); ?></h4>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="item-description-tab" data-toggle="tab"
                                       href="#item-description" role="tab" aria-controls="item-description"
                                       aria-selected="false">
                                        <h4><?php echo e('Description'); ?></h4>
                                    </a>
                                </li>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 mt-4 mb-3" id="itemsDetailsTabsContent">
                                <div class="tab-pane show active" id="item-details" role="tabpanel"
                                     aria-labelledby="item-details-tab">
                                    <div class="row">
                                        <div class="items-details-info col-md-12 col-sm-12 col-xs-12 enable-long-words from-wysiwyg">


                                            <!-- Custom Fields -->
                                        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.fields-values', 'post.inc.fields-values'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                        <!-- Tags -->
                                            <?php if(!empty($post->tags)): ?>
                                                <?php $tags = array_map('trim', explode(',', $post->tags)); ?>
                                                <?php if(!empty($tags)): ?>
                                                    <div class="row">
                                                        <div class="tags col-12">
                                                            <h4><i class="icon-tag"></i> <?php echo e(t('Tags')); ?>:</h4>
                                                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(\App\Helpers\UrlGen::tag($iTag)); ?>">
                                                                    <?php echo e($iTag); ?>

                                                                </a>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </div>

                                        <br>
                                    </div>
                                </div>

                                <div class="tab-pane" id="item-description" role="tabpanel"
                                     aria-labelledby="item-description-tab">
                                    <div class="row">
                                        <div class="items-details-info col-md-12 col-sm-12 col-xs-12 enable-long-words from-wysiwyg">
                                            <div class="row">
                                                <!-- Location -->
                                                <div class="detail-line-lite col-md-6 col-sm-6 col-xs-6">
                                                    <div>
                                                        <span><i class="fas fa-map-marker-alt"></i> <?php echo e(t('location')); ?>: </span>
                                                        <span>
															<a href="<?php echo \App\Helpers\UrlGen::city($post->city); ?>">
																<?php echo e($post->city->name); ?>

															</a>
														</span>
                                                    </div>
                                                </div>

                                            <?php if(!in_array($post->category->type, ['not-salable'])): ?>
                                                <!-- Price / Salary -->
                                                    <div class="detail-line-lite col-md-6 col-sm-6 col-xs-6">
                                                        <div>
															<span>
																<?php echo e((!in_array($post->category->type, ['job-offer', 'job-search'])) ? t('price') : t('Salary')); ?>:
															</span>
                                                            <span>
																<?php if($post->price > 0): ?>
                                                                    <?php echo \App\Helpers\Number::money($post->price); ?>

                                                                <?php else: ?>
                                                                    <?php echo \App\Helpers\Number::money(' --'); ?>

                                                                <?php endif; ?>
                                                                <?php if($post->negotiable == 1): ?>
                                                                    <small class="label badge-success"> <?php echo e(t('negotiable')); ?></small>
                                                                <?php endif; ?>
															</span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <hr>

                                            <!-- Description -->
                                            <div class="row">
                                                <div class="col-12 detail-line-content">
                                                    <?php echo transformDescription($post->description); ?>

                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="row detail-line-action text-center">
                                                <div class="col-4">
                                                    <?php if(auth()->check()): ?>
                                                        <?php if(auth()->user()->id == $post->user_id): ?>
                                                            <a href="<?php echo e(url('posts/' . $post->id . '/edit')); ?>">
                                                                <i class="icon-pencil-circled tooltipHere"
                                                                   data-toggle="tooltip"
                                                                   data-original-title="<?php echo e(t('Edit')); ?>"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-4">
                                                    <!-- <a class="make-favorite" id="<?php echo e($post->id); ?>"
                                                       href="javascript:void(0)">
                                                        <?php if(auth()->check()): ?>
                                                            <?php if(\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0): ?>
                                                                <i class="fa fa-heart tooltipHere" data-toggle="tooltip"
                                                                   data-original-title="<?php echo e(t('Remove favorite')); ?>"></i>
                                                            <?php else: ?>
                                                                <i class="tooltipHere far fa-heart"
                                                                   data-toggle="tooltip"
                                                                   data-original-title="<?php echo e(t('Save ad')); ?>"></i>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <i class="tooltipHere far fa-heart"
                                                               data-toggle="tooltip"
                                                               data-original-title="<?php echo e(t('Save ad')); ?>"></i>
                                                        <?php endif; ?>
                                                    </a> -->
                                                </div>
                                                <div class="col-4">
                                                    <a href="<?php echo e(url('posts/' . $post->id . '/report')); ?>">
                                                        <i class="fa icon-info-circled-alt tooltipHere"
                                                           data-toggle="tooltip"
                                                           data-original-title="<?php echo e(t('Report abuse')); ?>"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.tab content -->

                            <div class="content-footer text-left">
                                <?php if(auth()->check()): ?>
                                    <?php if(auth()->user()->id == $post->user_id): ?>
                                        <a class="btn btn-default" href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>">
                                            <i class="fa fa-pencil-square-o"></i> <?php echo e(t('Edit')); ?></a>
                                    <?php else: ?>
                                        <?php echo genPhoneNumberBtn($post); ?>

                                        
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo genPhoneNumberBtn($post); ?>

                                    
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="items-details pb-3">
                            <div class="mt-3">
                                <?php if(config('plugins.reviews.installed')): ?>
                                    <?php if(view()->exists('reviews::ratings-single')): ?>
                                        <?php echo $__env->make('reviews::ratings-single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <h4>
                                <?php echo e(trans('reviews::messages.Reviews')); ?>

                                <?php if(isset($rvPost) and !empty($rvPost)): ?>
                                    (<?php echo e($rvPost->rating_count); ?>)
                                <?php endif; ?>
                            </h4>

                            <?php if(config('plugins.reviews.installed')): ?>
                                <?php if(view()->exists('reviews::comments')): ?>
                                    <?php echo $__env->make('reviews::comments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!--/.items-details-wrapper-->
                </div>
                <!--/.page-content-->

                <div class="col-lg-3 page-sidebar-right">
                    <aside>
                    <div class="main_price">
                        <div class="p_price">
                            <?php if(!in_array($post->category->type, ['not-salable'])): ?>
                                <h1 class="price_rs">
                                    <?php if($post->price > 0): ?>
                                        <?php echo \App\Helpers\Number::money($post->price); ?>

                                    <?php else: ?>
                                        <?php echo \App\Helpers\Number::money(' --'); ?>

                                    <?php endif; ?>
                                </h1>
                            <?php endif; ?>
                            <a class="make-favorite" id="<?php echo e($post->id); ?>"
                                href="javascript:void(0)">
                                <?php if(auth()->check()): ?>
                                    <?php if(\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0): ?>
                                        <i class="fa fa-heart tooltipHere" data-toggle="tooltip"
                                            data-original-title="<?php echo e(t('Remove favorite')); ?>"></i>
                                    <?php else: ?>
                                        <i class="tooltipHere far fa-heart"
                                            data-toggle="tooltip"
                                            data-original-title="<?php echo e(t('Save ad')); ?>"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="tooltipHere far fa-heart"
                                        data-toggle="tooltip"
                                        data-original-title="<?php echo e(t('Save ad')); ?>"></i>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="detail_det">
                            <span class="info-row">
                                <?php if(!config('settings.single.hide_dates')): ?>
                                    <span class="date"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
                                    <i class="icon-clock"></i> <?php echo $post->created_at_formatted; ?>

                                </span>
                                <?php endif; ?>
                                <span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
                                    <i class="icon-folder-circled"></i> <?php echo e((!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name); ?>

                                </span>
                                <span class="item-location"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
                                    <i class="fas fa-map-marker-alt"></i> <?php echo e($post->city->name); ?>

                                </span>
                                <span class="category"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
                                    <i class="icon-eye-3"></i> <?php echo e(\App\Helpers\Number::short($post->visits)); ?> <?php echo e(trans_choice('global.count_views', getPlural($post->visits))); ?>

                                </span>
                            </span>
                        </div>
                    </div>
                        <div class="card card-user-info sidebar-card">
                            <?php if(auth()->check() and auth()->id() == $post->user_id): ?>
                                <div class="card-header"><?php echo e(t('Manage Ad')); ?></div>
                            <?php else: ?>
                                <div class="block-cell user">
                                    <div class="cell-media">
                                        <img src="<?php echo e($post->user_photo_url); ?>" alt="<?php echo e($post->contact_name); ?>">
                                    </div>
                                    <div class="cell-content">
                                        <h5 class="title"><?php echo e(t('Posted by')); ?></h5>
                                        <span class="name">
											<?php if(isset($user) and !empty($user)): ?>
                                                <!-- <a href="<?php echo e(\App\Helpers\UrlGen::user($user)); ?>"> -->
                                                <!-- <?php echo e($user->id); ?> -->
                                                  <a href="<?php echo e(route('profile.details',[$user->id])); ?>">
													<?php echo e($post->contact_name); ?>

												</a>
                                            <?php else: ?>
                                                <?php echo e($post->contact_name); ?>

                                            <?php endif; ?>
										</span>

                                        <?php if(config('plugins.reviews.installed')): ?>
                                            <?php if(view()->exists('reviews::ratings-user')): ?>
                                              <?php $post_reviews = \App\Models\Post::with('reviews.user')->whereHas('reviews')->where('user_id',$post->user_id )->get();
                                                $rating=0;$total=0;
                                              ?>
                                              <?php $__currentLoopData = $post_reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post_review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $post_review->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $rating+=$review->rating; $total+=1 ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php if(config('plugins.reviews.installed')): ?>
                                                  <?php if(view()->exists('reviews::ratings-user')): ?>
                                                      <div class="rating">
                                                          <div class="reviews-widget ratings">
                                                              <p class="p-0 m-0">
                                                                  <?php for($i=1; $i <= 5 ; $i++): ?>
                                                                      <?php if($total == 0): ?>
                                                                          <span class="icon-star-empty"></span>
                                                                      <?php else: ?>
                                                                          <span class="icon-star<?php echo e(($i <=  $rating/$total) ? '' : '-empty'); ?>"></span>
                                                                      <?php endif; ?>
                                                                  <?php endfor; ?>
                                                                  <?php if($total != 0 ): ?>
                                                                      <span class="rating-label d-inline"><small>(<?php echo e($total); ?>)</small></span>
                                                                  <?php else: ?>
                                                                      <span class="rating-label d-inline"><small>(0)</small></span>
                                                                  <?php endif; ?>
                                                              </p>
                                                          </div>
                                                      </div>
                                                  <?php endif; ?>
                                              <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="card-content">
                                <?php $evActionStyle = 'style="border-top: 0;"'; ?>
                                <?php if(!auth()->check() or (auth()->check() and auth()->user()->getAuthIdentifier() != $post->user_id)): ?>
                                    <div class="card-body text-left">
                                        <div class="grid-col">
                                            <div class="col from">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?php echo e(t('location')); ?></span>
                                            </div>
                                            <div class="col to">
												<span>
													<a href="<?php echo \App\Helpers\UrlGen::city($post->city); ?>">
														<?php echo e($post->city->name); ?>

													</a>
												</span>
                                            </div>
                                        </div>
                                        <?php if(!config('settings.single.hide_dates')): ?>
                                            <?php if(isset($user) and !empty($user) and !is_null($user->created_at_formatted)): ?>
                                                <div class="grid-col">
                                                    <div class="col from">
                                                        <i class="fas fa-user"></i>
                                                        <span><?php echo e(t('Joined')); ?></span>
                                                    </div>
                                                    <div class="col to">
                                                        <span><?php echo $user->created_at_formatted; ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php $evActionStyle = 'style="border-top: 1px solid #ddd;"'; ?>
                                <?php endif; ?>

                                <div class="ev-action" <?php echo $evActionStyle; ?>>
                                    <?php if(auth()->check()): ?>
                                        <?php if(auth()->user()->id == $post->user_id): ?>
                                            <a href="<?php echo e(\App\Helpers\UrlGen::editPost($post)); ?>"
                                               class="btn btn-default btn-block">
                                                <i class="fa fa-pencil-square-o"></i> <?php echo e(t('Update the Details')); ?>

                                            </a>
                                            <?php if(config('settings.single.publication_form_type') == '1'): ?>
                                                <a href="<?php echo e(url('posts/' . $post->id . '/photos')); ?>"
                                                   class="btn btn-default btn-block">
                                                    <i class="icon-camera-1"></i> <?php echo e(t('Update Photos')); ?>

                                                </a>
                                                <?php if(isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0): ?>
                                                    <a href="<?php echo e(url('posts/' . $post->id . '/payment')); ?>"
                                                       class="btn btn-success btn-block">
                                                        <i class="icon-ok-circled2"></i> <?php echo e(t('Make It Premium')); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php
                                            $req = App\Models\MessageRequest::where('user_id', auth()->id())->where('post_id', $post->id)->where('status', 0)->get();
                                            $check = App\Models\MessageRequest::where('user_id', auth()->id())->where('post_id', $post->id)->get();
                                            //											dd($post->id);
                                            ?>
                                            <?php echo genPhoneNumberBtn($post, true); ?>

                                            <?php $rent_date = ''; if (isset($post->rent)){$rent_date = $post->rent->rent_endtime; } ?>
                                            <?php echo sendRequest($rent_date); ?>

                                            <?php echo genEmailContactBtn($post, true); ?>

                                            <a class="btn btn-default btn-block" data-toggle="modal" data-target="#send_offer_request"><i class="far fa-envelope-open"></i> Send Offer Request</a>
                                            
                                            <?php if( $check->isEmpty() == 'asdfasdf'): ?>
                                                <form method="POST" action="<?php echo e(route('sendRequest')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>">
                                                    <input type="hidden" name="post" value="<?php echo e($post); ?>">

                                                </form>
                                            <?php elseif(!$req->isEmpty() == 'asdfasdfasdf'): ?>
                                                <?php echo pendingRequest(); ?>

                                            <?php else: ?>
                                              <!-- <?php $rent_date = ''; if (isset($post->rent)){$rent_date = $post->rent->rent_endtime; } ?>
                                              <?php echo sendRequest($rent_date); ?>

                                              <?php echo genEmailContactBtn($post, true); ?> -->
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php
                                        try {
                                            if (auth()->user()->can(\App\Models\Permission::getStaffPermissions())) {
                                                $btnUrl = admin_url('blacklists/add') . '?email=' . $post->email;

                                                if (!isDemo($btnUrl)) {
                                                    $cMsg = trans('admin.confirm_this_action');
                                                    $cLink = "window.location.replace('" . $btnUrl . "'); window.location.href = '" . $btnUrl . "';";
                                                    $cHref = "javascript: if (confirm('" . addcslashes($cMsg, "'") . "')) { " . $cLink . " } else { void('') }; void('')";

                                                    $btnText = trans('admin.ban_the_user');
                                                    $btnHint = trans('admin.ban_the_user_email', ['email' => $post->email]);
                                                    $tooltip = ' data-toggle="tooltip" data-placement="bottom" title="' . $btnHint . '"';

                                                    $btnOut = '';
                                                    $btnOut .= '<a href="' . $cHref . '" class="btn btn-danger btn-block"' . $tooltip . '>';
                                                    $btnOut .= $btnText;
                                                    $btnOut .= '</a>';

                                                    echo $btnOut;
                                                }
                                            }
                                        } catch (\Exception $e) {
                                        }
                                        ?>
                                    <?php else: ?>
                                        <?php echo genPhoneNumberBtn($post, true); ?>

                                        
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php if(config('settings.single.show_post_on_googlemap')): ?>
                            <div class="card sidebar-card">
                                <div class="card-header"><?php echo e(t('location_map')); ?></div>
                                <div class="card-content">
                                    <div class="card-body text-left p-0">
                                        <div class="ads-googlemaps">
                                            <iframe id="googleMaps" width="100%" height="250" frameborder="0"
                                                    scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(isVerifiedPost($post)): ?>
                            <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.social.horizontal', 'layouts.inc.social.horizontal'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>

                        <div class="card sidebar-card">
                            <div class="card-header"><?php echo e(t('Safety Tips for Buyers')); ?></div>
                            <div class="card-content">
                                <div class="card-body text-left">
                                    <ul class="list-check">
                                        <li> <?php echo e(t('Meet seller at a public place')); ?> </li>
                                        <li> <?php echo e(t('Check the item before you buy')); ?> </li>
                                        <li> <?php echo e(t('Pay only after collecting the item')); ?> </li>
                                    </ul>
                                    <?php $tipsLinkAttributes = getUrlPageByType('tips'); ?>
                                    <?php if(!\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href="#"') and !\Illuminate\Support\Str::contains($tipsLinkAttributes, 'href=""')): ?>
                                        <p>
                                            <a class="pull-right" <?php echo $tipsLinkAttributes; ?>>
                                                <?php echo e(t('Know more')); ?>

                                                <i class="fa fa-angle-double-right"></i>
                                            </a>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

        </div>

        <?php if(config('settings.single.similar_posts') == '1' || config('settings.single.similar_posts') == '2'): ?>
            <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'home.inc.featured', 'home.inc.featured'], ['firstSection' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'], ['firstSection' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if(isVerifiedPost($post)): ?>
            <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.facebook-comments', 'layouts.inc.tools.facebook-comments'], ['firstSection' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal_message'); ?>
    <?php if(config('settings.single.show_security_tips') == '1'): ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.security-tips', 'post.inc.security-tips'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <?php if(auth()->check() or config('settings.single.guests_can_contact_ads_authors')=='1'): ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.messenger.modal.create', 'account.messenger.modal.create'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    <!-- bxSlider CSS file -->
    <?php if(config('lang.direction') == 'rtl'): ?>
        <link href="<?php echo e(url('assets/plugins/bxslider/jquery.bxslider.rtl.css')); ?>" rel="stylesheet"/>
    <?php else: ?>
        <link href="<?php echo e(url('assets/plugins/bxslider/jquery.bxslider.css')); ?>" rel="stylesheet"/>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('before_scripts'); ?>
    <script>
        var showSecurityTips = '<?php echo e(config('settings.single.show_security_tips', '0')); ?>';
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <?php if(config('services.googlemaps.key')): ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('services.googlemaps.key')); ?>"
                type="text/javascript"></script>
    <?php endif; ?>

    <!-- bxSlider Javascript file -->
    <script src="<?php echo e(url('assets/plugins/bxslider/jquery.bxslider.min.js')); ?>"></script>

    <script>
    $('#myCarousel').carousel({
  interval: false
});
$('#carousel-thumbs').carousel({
  interval: false
});

// handles the carousel thumbnails
// https://stackoverflow.com/questions/25752187/bootstrap-carousel-with-thumbnails-multiple-carousel
$('[id^=carousel-selector-]').click(function() {
  var id_selector = $(this).attr('id');
  var id = parseInt( id_selector.substr(id_selector.lastIndexOf('-') + 1) );
  $('#myCarousel').carousel(id);
});
// when the carousel slides, auto update
$('#myCarousel').on('slide.bs.carousel', function(e) {
  var id = parseInt( $(e.relatedTarget).attr('data-slide-number') );
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id=carousel-selector-'+id+']').addClass('selected');
});
// when user swipes, go next or previous
$('#myCarousel').swipe({
  fallbackToMouseEvents: true,
  swipeLeft: function(e) {
    $('#myCarousel').carousel('next');
  },
  swipeRight: function(e) {
    $('#myCarousel').carousel('prev');
  },
  allowPageScroll: 'vertical',
  preventDefaultEvents: false,
  threshold: 75
});
/*
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
*/

$('#myCarousel .carousel-item img').on('click', function(e) {
  var src = $(e.target).attr('data-remote');
  if (src) $(this).ekkoLightbox();
});
</script>


    <script>
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

        $(document).ready(function () {
            $('[rel="tooltip"]').tooltip({trigger: "hover"});

            /* bxSlider - Main Images */
            $('.bxslider').bxSlider({
                touchEnabled: <?php echo e((count($post->pictures) > 1) ? 'true' : 'false'); ?>,
                speed: 1000,
                pagerCustom: '#bx-pager',
                adaptiveHeight: true,
                nextText: '<?php echo e(t('bxslider.nextText')); ?>',
                prevText: '<?php echo e(t('bxslider.prevText')); ?>',
                startText: '<?php echo e(t('bxslider.startText')); ?>',
                stopText: '<?php echo e(t('bxslider.stopText')); ?>',
                onSlideAfter: function ($slideElement, oldIndex, newIndex) {
                    <?php if(!userBrowser('Chrome')): ?>
                    $('#bx-pager li:not(.bx-clone)').eq(newIndex).find('a.thumb-item-link').addClass('active');
                    <?php endif; ?>
                }
            });

            /* bxSlider - Thumbnails */
            <?php if(userBrowser('Chrome')): ?>
            $('#bx-pager').addClass('m-3');
            $('#bx-pager .thumb-item-link').unwrap();
                    <?php else: ?>
            var thumbSlider = $('.product-view-thumb').bxSlider(bxSliderSettings());
            $(window).on('resize', function () {
                thumbSlider.reloadSlider(bxSliderSettings());
            });
            <?php endif; ?>

            <?php if(config('settings.single.show_post_on_googlemap')): ?>
            /* Google Maps */
            getGoogleMaps(
                '<?php echo e(config('services.googlemaps.key')); ?>',
                '<?php echo e((isset($post->city) and !empty($post->city)) ? addslashes($post->city->name) . ',' . config('country.name') : config('country.name')); ?>',
                '<?php echo e(config('app.locale')); ?>'
            );
            <?php endif; ?>

            /* Keep the current tab active with Twitter Bootstrap after a page reload */
            /* For bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                /* save the latest tab; use cookies if you like 'em better: */
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            /* Go to the latest tab, if it exists: */
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });

        /* bxSlider - Initiates Responsive Carousel */
        function bxSliderSettings() {
            var smSettings = {
                slideWidth: 65,
                minSlides: 1,
                maxSlides: 4,
                slideMargin: 5,
                adaptiveHeight: true,
                pager: false
            };
            var mdSettings = {
                slideWidth: 100,
                minSlides: 1,
                maxSlides: 4,
                slideMargin: 5,
                adaptiveHeight: true,
                pager: false
            };
            var lgSettings = {
                slideWidth: 100,
                minSlides: 3,
                maxSlides: 6,
                pager: false,
                slideMargin: 10,
                adaptiveHeight: true
            };

            if ($(window).width() <= 640) {
                return smSettings;
            } else if ($(window).width() > 640 && $(window).width() < 768) {
                return mdSettings;
            } else {
                return lgSettings;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/post/details.blade.php ENDPATH**/ ?>