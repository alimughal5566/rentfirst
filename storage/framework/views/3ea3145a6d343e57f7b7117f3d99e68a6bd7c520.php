

<?php $__env->startSection('search'); ?>
    ##parent-placeholder-3559d7accf00360971961ca18989adc0614089c0##
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-container" id="homepage">
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
        <?php endif; ?>

        <?php if(isset($sections) and $sections->count() > 0): ?>
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(view()->exists($section->view)): ?>
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . $section->view, $section->view], ['firstSection' => $loop->first], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <div class="above-footer-banner mx-auto w-100">
            <?php  $above_footer = \App\Models\Setting::where('key', 'above_footer')->first(); ?>
            <?php if(isset($above_footer)): ?>
                <?php $__currentLoopData = $above_footer->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($image['status']=='on'): ?>
                         <img class="img-fluid" src="<?php echo e(asset('images/'.$image['image'])); ?>" alt="">
                          <?php break; ?>
                    <?php endif; ?>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <script>
        <?php if(config('settings.optimization.lazy_loading_activation') == 1): ?>
        $(document).ready(function () {
            $('#postsList').each(function () {
                var $masonry = $(this);
                var update = function () {
                    $.fn.matchHeight._update();
                };
                $('.item-list', $masonry).matchHeight();
                this.addEventListener('load', update, true);
            });
        });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
<script src="//js.pusher.com/3.1/pusher.min.js"></script> 
      <script>
      Pusher.logToConsole = true;
      var pusher = new Pusher('2145dcb18e6bdec67070', {
         cluster: 'ap2',
    encrypted: true
});

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('notification');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\NotificationEvent', function(data) {
   checkNewMessages();
   console.log('ok');
   
    // this is called when the event notification is received...
});
      </script>
      <?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/index.blade.php ENDPATH**/ ?>