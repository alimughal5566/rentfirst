


<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">
    
                <div class="col-md-3 page-sidebar">
                    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <!--/.page-sidebar-->
                
                <div class="col-md-9 page-content">
                    <div class="inner-box">
                        <h2 class="title-2">
                            <i class="icon-mail"></i> <?php echo e(t('inbox')); ?>

                        </h2>
    
                        <?php if(Session::has('flash_notification')): ?>
                            <div class="row">
                                <div class="col-xl-12">
                                    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($errors) and $errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="list list-check">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mb-0"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
    
                        <div id="successMsg" class="alert alert-success hide" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger hide" role="alert"></div>
                        
                        <div class="inbox-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="user-bar-top">
                                        <div class="user-top">
                                            <p>
                                                <a href="<?php echo e(url('account/messages')); ?>">
                                                    <i class="fas fa-inbox"></i>
                                                </a>&nbsp;
                                                <?php if(auth()->id() != $thread->creator()->id): ?>
                                                    <a href="#user">
                                                        <?php if(isUserOnline($thread->creator())): ?>
                                                            <i class="fa fa-circle color-success"></i>&nbsp;
                                                        <?php endif; ?>
                                                        <strong>
                                                            <a href="<?php echo e(\App\Helpers\UrlGen::user($thread->creator())); ?>">
                                                                <?php echo e($thread->creator()->name); ?>

                                                            </a>
                                                        </strong>
                                                    </a>
                                                <?php endif; ?>
                                                <strong><?php echo e(t('Contact request about')); ?></strong> <a href="<?php echo e(\App\Helpers\UrlGen::post($thread->post)); ?>"><?php echo e($thread->post->title); ?></a>
                                            </p>
                                        </div>
    
                                        <div class="message-tool-bar-right pull-right call-xhr-action">
                                            <div class="btn-group btn-group-sm">
                                                <?php if($thread->isImportant()): ?>
                                                    <a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsNotImportant')); ?>"
                                                       class="btn btn-secondary markAsNotImportant"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title=""
                                                       data-original-title="<?php echo e(t('Mark as not important')); ?>"
                                                    >
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsImportant')); ?>"
                                                       class="btn btn-secondary markAsImportant"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title=""
                                                       data-original-title="<?php echo e(t('Mark as important')); ?>"
                                                    >
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=delete')); ?>"
                                                   class="btn btn-secondary"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title=""
                                                   data-original-title="<?php echo e(t('Delete')); ?>"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php if($thread->isUnread()): ?>
                                                    <a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsRead')); ?>"
                                                       class="btn btn-secondary markAsRead"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title=""
                                                       data-original-title="<?php echo e(t('Mark as read')); ?>"
                                                    >
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsUnread')); ?>"
                                                       class="btn btn-secondary markAsRead"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       title=""
                                                       data-original-title="<?php echo e(t('Mark as unread')); ?>"
                                                    >
                                                        <i class="fas fa-envelope-open"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <?php echo $__env->make('account.messenger.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                <div class="col-md-9 col-lg-10 chat-row">
                                    <div class="message-chat p-2 rounded">
                                        <div id="messageChatHistory" class="message-chat-history">
                                            <div id="linksMessages" class="text-center">
                                                <?php echo $linksRender; ?>

                                            </div>
                                            
                                            <?php echo $__env->make('account.messenger.messages.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            
                                        </div>

                                        <div class="type-message">
                                            <div class="type-form">
                                                <?php $updateUrl = url('account/messages/' . $thread->id); ?>
                                                <form id="chatForm" role="form" method="POST" action="<?php echo e($updateUrl); ?>" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>

                                                    <div id="chatform_d">
                                                        <div id="chat_form_fields" >
                                                            <input name="_method" type="hidden" value="PUT">
                                                            <textarea id="body"
                                                                  name="body"
                                                                  maxlength="500"
                                                                  rows="3"
                                                                  class="input-write form-control"
                                                                  placeholder="Type a message"
                                                                  style="<?php echo e((config('lang.direction')=='rtl') ? 'padding-left' : 'padding-right'); ?>: 75px;"></textarea>
                                                            <div class="button-wrap">
                                                                <?php if(auth()->id() == $thread->user_id): ?>
                                                                    <a onclick="make_offer()" id="make_offer" class="btn btn-primary" >
                                                                        <i class="fas fa-gift"></i>
                                                                    </a>




                                                                <?php endif; ?>

                                                                <input id="addFile" name="filename" type="file">
                                                                <button id="sendChat" class="btn btn-primary" type="submit">
                                                                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>





















                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/. inbox-wrapper-->
                    </div>
                </div>
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!-- /.main-container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    ##parent-placeholder-bb86d4c64894d7d4416e528718347e64591a36f9##
    <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
    <?php if(config('lang.direction') == 'rtl'): ?>
        <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        .file-input {
            display: inline-block;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##

    <script>
        function make_offer() {

            $("#chat_form_fields").html('');
            $("#chatform_d").html('<div class="make_an_offer" id="make_an_offer" >\n' +
                                    '<input name="_method" type="hidden" value="PUT"><div class="row" style="margin-top: 10px;">\n' +
                                        '<div class="col-10">\n' +
                                            '<h3 style="text-align: left; ">Make an offer</h3>\n' +
                                        '</div>\n' +
                                        '<div class="col-2">\n' +
                                            '<a id="close_offer" onclick="close_offer()" class="btn" style="border: 1px solid black; height: 20px;     height: 30px; width: 30px;    display: flex;    align-items: center;    justify-content: center;" > X </a>\n' +
                                        '</div>\n' +
                                    '</div>\n' +
                                    '<div class="row">\n' +
                                        '<div class="col-7">\n' +
                                            '<input type="number" class="form-control" name="body" placeholder="Enter the amount">\n' +
                                            '<input type="hidden" name="gift_offer" value="offer" >\n' +
                                        '</div>\n' +
                                        '<div class="col-4">\n' +
                                            '<button id="sendChat" class="btn btn-primary" type="submit">\n' +
                                                '<i class="fas fa-paper-plane" aria-hidden="true"></i>\n' +
                                            '</button>\n' +
                                        '</div>\n' +
                                    '</div>\n' +
                                '</div>');
        }
        function close_offer() {
            $("#make_an_offer").html('');
            let container = `
             <div id="chat_form_fields" >
                <input name="_method" type="hidden" value="PUT">
                <textarea id="body"
                      name="body"
                      maxlength="500"
                      rows="3"
                      class="input-write form-control"
                      placeholder="Type a message"
                      style="padding-right: 75px;"></textarea>
                <div class="button-wrap">

            <a onclick="make_offer()" id="make_offer" class="btn btn-primary" >
                <i class="fas fa-gift"></i>
            </a>
           <div class="file-input file-input-new theme-fa"><div tabindex="500" class="btn btn-primary btn-file"><i class="fas fa-paperclip" aria-hidden="true"></i><input id="addFile" name="filename" type="file"></div></div>
            <button id="sendChat" class="btn btn-primary" type="submit">
                <i class="fas fa-paper-plane" aria-hidden="true"></i>
            </button>

        </div>
    </div>
    `
            $("#chatform_d").html(container);

        }
        var loadingImage = '<?php echo e(url('images/loading.gif')); ?>';
        var loadingErrorMessage = '<?php echo e(t('Threads could not be loaded')); ?>';
        var confirmMessage = '<?php echo e(t('confirm_this_action')); ?>';
        var actionErrorMessage = '<?php echo e(t('This action could not be done')); ?>';
        var title = {
            'seen': '<?php echo e(t('Mark as read')); ?>',
            'notSeen': '<?php echo e(t('Mark as unread')); ?>',
            'important': '<?php echo e(t('Mark as important')); ?>',
            'notImportant': '<?php echo e(t('Mark as not important')); ?>',
        };
    </script>
    <script src="<?php echo e(url('assets/js/app/messenger.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/js/app/messenger-chat.js')); ?>" type="text/javascript"></script>
    
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
    
    <script>
        /* Initialize with defaults (filename) */
        $('#addFile').fileinput(
        {
            theme: "fa",
            language: '<?php echo e(config('app.locale')); ?>',
            <?php if(config('lang.direction') == 'rtl'): ?>
            rtl: true,
            <?php endif; ?>
            allowedFileExtensions: <?php echo getUploadFileTypes('file', true); ?>,
            maxFileSize: <?php echo e((int)config('settings.upload.max_file_size', 1000)); ?>,
            browseClass: 'btn btn-primary',
            browseIcon: '<i class="fas fa-paperclip" aria-hidden="true"></i>',
            layoutTemplates: {
                main1: '{browse}',
                main2: '{browse}',
                btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}</div>',
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/show.blade.php ENDPATH**/ ?>