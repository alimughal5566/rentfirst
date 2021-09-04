<?php $hideOnMobile = isset($hideOnMobile) ? $hideOnMobile : ''; ?>
<?php if(isset($paddingTopExists)): ?>
	<?php if(isset($firstSection) and !$firstSection): ?>
		<div class="h-spacer<?php echo e($hideOnMobile); ?>"></div>
	<?php else: ?>
		<?php if(!$paddingTopExists): ?>
			<div class="h-spacer<?php echo e($hideOnMobile); ?>"></div>
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
	<div class="h-spacer<?php echo e($hideOnMobile); ?>"></div>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/home/inc/spacer.blade.php ENDPATH**/ ?>