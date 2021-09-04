<?php if(isset($messages)): ?>
	<?php if($messages->count() > 0): ?>
		<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->make('account.messenger.messages.message', ['message' => $message], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/messages/messages.blade.php ENDPATH**/ ?>