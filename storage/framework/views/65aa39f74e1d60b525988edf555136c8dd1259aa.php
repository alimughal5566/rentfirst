<!-- Show AJAX Errors (for JS) -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="errorModalTitle">
					Title
				</h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only"><?php echo e(t('Close')); ?></span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row">
					<div id="errorModalBody" class="col-12">
						Content...
					</div>
				</div>
			</div>
			
			<div class='modal-footer'>
				<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(t('Close')); ?></button>
			</div>
			
		</div>
	</div>
</div>

<?php $__env->startSection('after_scripts'); ?>
	##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
<?php $__env->stopSection(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/layouts/inc/modal/error.blade.php ENDPATH**/ ?>