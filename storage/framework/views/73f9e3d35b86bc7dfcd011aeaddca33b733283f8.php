


<?php $__env->startSection('wizard'); ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
// The Next Step URL
$nextStepUrl = url($nextStepUrl);
$nextStepUrl = qsUrl($nextStepUrl, request()->only(['package']), null, false);
?>
<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-container">
        <div class="container">
            <div class="row">

                <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-md-12 page-content">
                    <div class="inner-box">

                        <h2 class="title-2">
							<strong><i class="icon-camera-1"></i> <?php echo e(t('Photos')); ?></strong>
							<?php
							try {
								if (auth()->check()) {
									if (auth()->user()->can(\App\Models\Permission::getStaffPermissions())) {
										$postLink = '-&nbsp;<a href="' . \App\Helpers\UrlGen::post($post) . '"
												  class="tooltipHere"
												  title=""
												  data-placement="top"
												  data-toggle="tooltip"
												  data-original-title="' . $post->title . '"
										>' . \Illuminate\Support\Str::limit($post->title, 45) . '</a>';

										echo $postLink;
									}
								}
							} catch (\Exception $e) {}
							?>
						</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" id="postForm" method="POST" action="<?php echo e(request()->fullUrl()); ?>" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
                                    <fieldset>
                                        <?php if(isset($picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0): ?>
											
											<?php $picturesError = (isset($errors) and $errors->has('pictures')) ? ' is-invalid' : ''; ?>
                                            <div id="picturesBloc" class="form-group row">
												<label class="col-md-3 control-label<?php echo e($picturesError); ?>" for="pictures"> <?php echo e(t('pictures')); ?> </label>
												<div class="col-md-8"></div>
												<div class="col-md-12 text-center pt-2" style="position: relative; float: <?php echo (config('lang.direction')=='rtl') ? 'left' : 'right'; ?>;">
													<div <?php echo (config('lang.direction')=='rtl') ? 'dir="rtl"' : ''; ?> class="file-loading">
														<input id="pictureField" name="pictures[]" type="file" multiple class="file picimg<?php echo e($picturesError); ?>">
													</div>
													<small id="" class="form-text text-muted">
														<?php echo e(t('add_up_to_x_pictures_text', [
															'pictures_number' => $picturesLimit
														])); ?>

													</small>
												</div>
                                            </div>
                                        <?php endif; ?>
                                        <div id="uploadError" class="mt-2" style="display: none;"></div>
                                        <div id="uploadSuccess" class="alert alert-success fade show mt-2" style="display: none;"></div>

										
                                        <div class="form-group row mt-4">
                                            <div class="col-md-12 text-center">
                                                <?php if(request()->segment(2) != 'create'): ?>
                                                    <a href="<?php echo e(url('posts/' . $post->id . '/edit')); ?>" class="btn btn-default btn-lg"><?php echo e(t('Previous')); ?></a>
                                                <?php endif; ?>
                                                <a id="nextStepAction" href="<?php echo e($nextStepUrl); ?>" class="btn btn-default btn-lg"><?php echo e(t('Skip')); ?></a>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_styles'); ?>
    <link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css')); ?>" rel="stylesheet">
	<?php if(config('lang.direction') == 'rtl'): ?>
		<link href="<?php echo e(url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css')); ?>" rel="stylesheet">
	<?php endif; ?>
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
		.file-loading:before {
			content: " <?php echo e(t('Loading')); ?>...";
		}
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(url('js/fileinput/locales/' . config('app.locale') . '.js')); ?>" type="text/javascript"></script>
    <script>
        /* Initialize with defaults (pictures) */
        <?php if(isset($post, $picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0): ?>
        <?php
            // Get Upload Url
            if (request()->segment(2) == 'create') {
                $uploadUrl = url('posts/create/' . $post->tmp_token . '/photos/');
            } else {
                $uploadUrl = url('posts/' . $post->id . '/photos/');
            }
            $uploadUrl = qsUrl($uploadUrl, request()->only(['package']), null, false);
        ?>
            $('#pictureField').fileinput(
            {
				theme: "fa",
                language: '<?php echo e(config('app.locale')); ?>',
				<?php if(config('lang.direction') == 'rtl'): ?>
					rtl: true,
				<?php endif; ?>
                overwriteInitial: false,
                showCaption: false,
                showPreview: true,
                allowedFileExtensions: <?php echo getUploadFileTypes('image', true); ?>,
				uploadUrl: '<?php echo e($uploadUrl); ?>',
                uploadAsync: false,
				showBrowse: true,
				showCancel: true,
				showUpload: false,
				showRemove: false,
				minFileSize: <?php echo e((int)config('settings.upload.min_image_size', 0)); ?>, 
                maxFileSize: <?php echo e((int)config('settings.upload.max_image_size', 1000)); ?>, 
                browseOnZoneClick: true,
                minFileCount: 0,
                maxFileCount: <?php echo e((int)$picturesLimit); ?>,
                validateInitialCount: true,
                <?php if(isset($post->pictures)): ?>
                /* Retrieve current images */
                /* Setup initial preview with data keys */
                initialPreview: [
                <?php for($i = 0; $i <= $picturesLimit-1; $i++): ?>
                    <?php if(!$post->pictures->has($i) or !isset($post->pictures->get($i)->filename)) continue; ?>
                    '<?php echo e(imgUrl($post->pictures->get($i)->filename, 'medium')); ?>',
                <?php endfor; ?>
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                /* Initial preview configuration */
                initialPreviewConfig: [
                <?php for($i = 0; $i <= $picturesLimit-1; $i++): ?>
                    <?php if(!$post->pictures->has($i) or !isset($post->pictures->get($i)->filename)) continue; ?>
                    <?php
					// Get the file path
					$filePath = $post->pictures->get($i)->filename;

                    // Get the file's deletion URL
                    if (request()->segment(2) == 'create') {
                        $initialPreviewConfigUrl = url('posts/create/' . $post->tmp_token . '/photos/' . $post->pictures->get($i)->id . '/delete');
                    } else {
                        $initialPreviewConfigUrl = url('posts/' . $post->id . '/photos/' . $post->pictures->get($i)->id . '/delete');
                    }

                    // Get the file size
					try {
						$fileSize = (isset($disk) && $disk->exists($filePath)) ? (int)$disk->size($filePath) : 0;
					} catch (\Exception $e) {
						$fileSize = 0;
					}
                    ?>
                    {
                        caption: '<?php echo e(last(explode(DIRECTORY_SEPARATOR, $filePath))); ?>',
                        size: <?php echo e($fileSize); ?>,
                        url: '<?php echo e($initialPreviewConfigUrl); ?>',
						key: <?php echo e((int)$post->pictures->get($i)->id); ?>

                    },
                <?php endfor; ?>
                ],
                <?php endif; ?>

                elErrorContainer: '#uploadError',
				msgErrorClass: 'alert alert-block alert-danger',

				uploadClass: 'btn btn-success'
            });
        <?php endif; ?>

		/* Auto-upload added file */
		$('#pictureField').on('filebatchselected', function(event, data, id, index) {
			if (typeof data === 'object') {
				
				if (data.hasOwnProperty('0')) {
					$(this).fileinput('upload');
					return true;
				}
			}

			return false;
		});

		/* Show upload status message */
        $('#pictureField').on('filebatchpreupload', function(event, data, id, index) {
            $('#uploadSuccess').html('<ul></ul>').hide();
        });

		/* Show success upload message */
        $('#pictureField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
            /* Show uploads success messages */
            var out = '';
            $.each(data.files, function(key, file) {
                if (typeof file !== 'undefined') {
                    var fname = file.name;
                    out = out + <?php echo t('Uploaded file X successfully'); ?>;
                }
            });
            $('#uploadSuccess ul').append(out);
            $('#uploadSuccess').fadeIn('slow');

            /* Change button label */
            $('#nextStepAction').html('<?php echo e($nextStepLabel); ?>').removeClass('btn-default').addClass('btn-primary');

            /* Check redirect */
            var maxFiles = <?php echo e((isset($picturesLimit)) ? (int)$picturesLimit : 1); ?>;
            var oldFiles = <?php echo e((isset($post) and isset($post->pictures)) ? $post->pictures->count() : 0); ?>;
            var newFiles = Object.keys(data.files).length;
            var countFiles = oldFiles + newFiles;
            if (countFiles >= maxFiles) {
                var nextStepUrl = '<?php echo e($nextStepUrl); ?>';
				redirect(nextStepUrl);
            }
        });

		/* Reorder (Sort) files */
		$('#pictureField').on('filesorted', function(event, params) {
			picturesReorder(params);
		});

		/* Delete picture */
        $('#pictureField').on('filepredelete', function(jqXHR) {
            var abort = true;
            if (confirm("<?php echo e(t('Are you sure you want to delete this picture')); ?>")) {
                abort = false;
            }
            return abort;
        });

		/**
		 * Reorder (Sort) pictures
		 * @param  params
		 * @returns  {boolean}
		 */
		function picturesReorder(params)
		{
			if (typeof params.stack === 'undefined') {
				return false;
			}

			waitingDialog.show('<?php echo e(t('Processing')); ?>...');

			$.ajax({
				method: 'POST',
				url: siteUrl + '/ajax/post/pictures/reorder',
				data: {
					'params': params,
					'_token': $('input[name=_token]').val()
				}
			}).done(function(data) {

				setTimeout(function() {
					waitingDialog.hide();
				}, 250);

				if (typeof data.status === 'undefined') {
					return false;
				}

				/* Reorder Notification */
				if (parseInt(data.status) === 1) {
					$('#uploadSuccess').html('<ul></ul>').hide();
					$('#uploadSuccess ul').append('<?php echo e(t('Your picture has been reorder successfully')); ?>');
					$('#uploadSuccess').fadeIn('slow');
				}

				return false;
			});

			return false;
		}
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/post/createOrEdit/multiSteps/photos.blade.php ENDPATH**/ ?>