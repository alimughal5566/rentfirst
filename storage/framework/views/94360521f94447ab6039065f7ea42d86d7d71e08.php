<div class="reviews-widget tab-pane" id="item-reviews">
    <div class="row">

        <?php if(isset($post) and !empty($post)): ?>
            <?php
            if (!isset($rvPost) || empty($rvPost)) {
                $rvPost = \extras\plugins\reviews\app\Models\Post::withoutGlobalScopes([\App\Models\Scopes\ActiveScope::class, \App\Models\Scopes\ReviewedScope::class])->find($post->id);
            }
            ?>

            <?php if(isset($rvPost) and !empty($rvPost)): ?>
            <?php
                // Get all reviews that are not spam for the product and paginate them
                $reviews = $rvPost->reviews()->with('user')->approved()->notSpam()->orderBy('created_at','desc')->paginate(20);
            ?>
            <div class="col-md-12 well" id="reviews-anchor">

                <?php if(Session::get('errors')): ?>
                    <div class="row pt-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger mb-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><strong><?php echo e(trans('reviews::messages.There were errors while submitting this review')); ?>:</strong></h5>
                                <ul class="list list-check">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(Session::has('review_posted')): ?>
                    <div class="row pt-3">
                        <div class="col-md-12">
                            <div class="alert alert-success mb-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p class="mb-0"><strong><?php echo e(trans('reviews::messages.Your review has been posted!')); ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(Session::has('review_removed')): ?>
                    <div class="row pt-3">
                        <div class="col-md-12">
                            <div class="alert alert-success mb-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p class="mb-0"><strong><?php echo e(trans('reviews::messages.Your review has been removed!')); ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row pb-3" id="post-review-box">
                    <?php if(!auth()->check() and !config('settings.reviews.guests_comments')): ?>
                        <div class="col-md-12 text-center pb-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <strong><?php echo e(trans('reviews::messages.Note')); ?>:</strong> <?php echo e(trans('reviews::messages.You must be logged in to post a review.')); ?>

                                </div>
                                <div class="col-12">
                                    <form action="<?php echo e(lurl(trans('/login'))); ?>" method="post" class="m-0 p-0">
                                        <?php echo csrf_field(); ?>

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 pl-1 pr-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="login" placeholder="E-mail">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12 pl-1 pr-1">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12 pl-1 pr-1">
                                                <input type="hidden" name="g-recaptcha-response" value="1">
                                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                      <?php $gift_message = \App\Models\GiftMessage::where('sender_id', auth()->user()->id)->where('status', 1)->where('review_status', 0)->first(); ?>
                        <?php if(!empty($gift_message)): ?>
                          <div class="col-md-12">
                              <form action="<?php echo e(route('rating-save',['id' => $rvPost->id, 'gift_id'=> $gift_message->id])); ?>" method="post">
                                  <?php echo csrf_field(); ?>

                                  <input type="hidden" name="rating" id="rating">
                                  <div class="form-group row required mb-0 <?php echo (isset($errors) and $errors->has('comment')) ? 'has-error' : ''; ?>">
                                      <div class="col-md-12 pt-3 pl-3 pr-3 pb-0">
                                          <textarea name="comment"
                                                    id="comment"
                                                    rows="5"
                                                    class="form-control animated"
                                                    placeholder="<?php echo e(trans('reviews::messages.Enter your review here...')); ?>" required
                                          ><?php echo e(old('comment')); ?></textarea>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <div class="col-md-12 text-right">
                                          <div class="stars starrr" data-rating="<?php echo e(old('rating', 0)); ?>"></div>
                                          <button class="btn btn-success btn-lg" type="submit"><?php echo e(trans('reviews::messages.Leave a Review')); ?></button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                        <?php endif; ?>

                        <?php $gift_message2 = \App\Models\GiftMessage::with('gift_msg.thread')->where('receiver_id', auth()->user()->id)->where('status', 1)->where('review_status', 1)->first(); ?>
                        <?php if(!empty($gift_message2) && $gift_message2->gift_msg->thread->post_id == $rvPost->id): ?>
                            <div class="col-md-12">
                                <form action="<?php echo e(route('rating-save-reviewer',['id' => $rvPost->id, 'gift_id'=> $gift_message2->id])); ?>" method="post">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="rating" id="rating">
                                    <div class="form-group row required mb-0 <?php echo (isset($errors) and $errors->has('comment')) ? 'has-error' : ''; ?>">
                                        <div class="col-md-12 pt-3 pl-3 pr-3 pb-0">
                                            <textarea name="comment"
                                                      id="comment"
                                                      rows="5"
                                                      class="form-control animated"
                                                      placeholder="<?php echo e(trans('reviews::messages.Enter your review here...')); ?>" required
                                            ><?php echo e(old('comment')); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12 text-right">
                                            <div class="stars starrr" data-rating="<?php echo e(old('rating', 0)); ?>"></div>
                                            <button class="btn btn-success btn-lg" type="submit"><?php echo e(trans('reviews::messages.Leave a Review')); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if($reviews->count() > 0): ?>
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <hr>
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
                                        <span style="margin-left: 10px; color: white; background-color: green; font-size: 10px; padding: 6px; border-radius: 8px" >Feedback</span>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('profile.details',[$review->user->id])); ?>">
                                            <?php echo e($review->user->name); ?>

                                        </a>
                                    <?php endif; ?>






                                </span>
                                    <br>
                                    <br>
                                <span class="pull-right"><?php echo e($review->timeago); ?></span>

                                <p><?php echo $review->comment; ?></p>

                                <div class="col-sm-12">
                                    <a onclick="show_reply(<?php echo e($review->id); ?>)" style="text-decoration:none;">Reply</a>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-8" style="margin-left: 50px;">
                                    <form method="post" action="<?php echo e(route('save_reply')); ?>" style="display: none" onsubmit="save_reply_form(this) " id="reply_form_<?php echo e($review->id); ?>">
                                        <hr>
                                        <input type="hidden" name="review_id" value="<?php echo e($review->id); ?>">
                                        <?php if(isset(auth()->user()->id)): ?>
                                        <input type="hidden" name="user_id" value="<?php echo e(auth()->user()->id); ?>">
                                        <?php endif; ?>
                                        <textarea required name="comment_reply" id="comment_reply" class="form-control"></textarea>
                                        <button class="btn btn-primary btn-sm mt-1" onclick="this.preventDefault" type="submit" >Save</button>
                                    </form>
                                    <div id="comment_replies<?php echo e($review->id); ?>">
                                        <?php $__currentLoopData = $review->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p style="font-weight: bold"><?php echo e($reply->user->name); ?></p>
                                                </div>
                                                <div class="col-6" style="text-align: right; ">
                                                    <?php echo e($reply->created_at->diffForHumans()); ?>

                                                </div>
                                            </div>
                                            <div class="col-12">
                                                 <p>Reply: <span style="color: #69D161"><?php echo e($reply->reply); ?></span></p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <nav class="mb-3">
                        <?php echo e($reviews->links()); ?>

                    </nav>

                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>

<?php $__env->startSection('after_styles'); ?>
    ##parent-placeholder-bb86d4c64894d7d4416e528718347e64591a36f9##
    <link href="<?php echo e(url('assets/reviews/js/starrr.css')); ?>" rel="stylesheet" type="text/css">
    <style type="text/css">
        .ads-details .tab-content {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .ads-details .well {
            margin-bottom: 0;
            border: 0;
            background-color: #fafafa;
        }
        #item-reviews {
            margin-top: 0;
        }
        #item-reviews > div {
            padding: 0 10px;
        }
        /* Enhance the look of the textarea expanding animation */
        .reviews-widget .animated {
            -webkit-transition: height 0.2s;
            -moz-transition: height 0.2s;
            transition: height 0.2s;
        }
        .reviews-widget .stars {
            margin: 20px 0;
            font-size: 24px;
            color: #ffc32b;
        }
        .reviews-widget .stars a {
            color: #ffc32b;
        }
        .reviews-widget .comments span.icon-star,
        .reviews-widget .comments span.icon-star-empty {
            margin-top: 5px;
            font-size: 16px;
            <?php if(config('lang.direction') == 'rtl'): ?>
            margin-left: -8px;
            <?php else: ?>
            margin-right: -8px;
            <?php endif; ?>
        }
        .reviews-widget .comments .rating-label {
            margin-top: 5px;
            font-size: 16px;
            <?php if(config('lang.direction') == 'rtl'): ?>
            margin-right: 4px;
            <?php else: ?>
            margin-left: 4px;
            <?php endif; ?>
        }

        @media (min-width: 576px) {
            #post-review-box .form-group {
                margin-bottom: 0;
            }
            #post-review-box .form-control {
                width: 100%;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <?php if(\Session::has('success')): ?>
       toastr.success('<?php echo \Session::get('success'); ?>');
   <?php endif; ?>

    <script src="<?php echo e(url('assets/reviews/js/autosize.js')); ?>"></script>
    <script src="<?php echo e(url('assets/reviews/js/starrr.js')); ?>"></script>
    <script>
      function show_reply(id){
          var exist = '<?php echo e(Auth::user()); ?>';
          if(!exist){
              alert("Kindly login first");
              exit;
          }
        $('#reply_form_'+id).css('display','block');
      }
      function save_reply_form(elm){
          let id =elm.id;
          $('#'+id).on('submit', function(e){e.preventDefault()});
          $.post( elm.action,$('#'+id).serializeArray() , function( res ) {
              toastr.success("Reply has been saved");
              <?php if(isset(auth()->user()->id)): ?>
                var name = "<?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>";
              <?php endif; ?>
              $('#'+id)[0].reset();
              $('#comment_replies'+res.reply.review_id).append(`
                <hr>
                <div class="row">
                    <div class="col-4">
                        <p style="font-weight: bold">`+name+`</p>
                    </div>
                    <div class="col-6" style="text-align: right; ">
                        1 second ago
                    </div>
                </div>
                <div class="col-12">
                    <p>Reply: <span style="color: #69D161">`+res.reply.reply+`</span></p>
                </div>
              `)
              console.log(res);
          });
      }
    </script>
    <script>
        $(document).ready(function () {
            /* Initialize the autosize plugin on the review text area */
            autosize($('#comment'));

            /* Bind the change event for the star rating - store the rating value in a hidden field */
            $('.starrr').starrr({
                change: function(e, value){
                    $('#rating').val(value);
                }
            });

            /* Delete comments confirmation */
            $(document).on('click', '.delete-comment', function(e)
            {
                e.preventDefault(); /* prevents the submit or reload */
                var confirmation = confirm("<?php echo trans('admin::messages.Are you sure you want to perform this action?'); ?>");

                if (confirmation) {
                    var deleteCommentUrl = $(this).attr('href');
                    window.location.replace(deleteCommentUrl);
                    window.location.href = deleteCommentUrl;
                }

                return false;
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/extras/plugins/reviews/resources/views/comments.blade.php ENDPATH**/ ?>