<?php if($threads->total() > 0): ?>
	<span class="text-muted count-message">
		<strong>
			<?php echo e($threads->currentPage()); ?>

		</strong> - <strong>
			<?php echo e($threads->count()); ?>

		</strong> <?php echo e(t('of')); ?> <strong>
			<?php echo e($threads->total()); ?>

		</strong>
	</span>
	<?php echo e($threads->appends(request()->query())->links('account.messenger.threads.pagination')); ?>

<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/threads/links.blade.php ENDPATH**/ ?>