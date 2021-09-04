<div class="list-group-item<?php echo e($thread->isUnread() ? '' : ' seen'); ?>">
	<div class="form-check">
		<div class="custom-control pl-0">
			<input type="checkbox" name="entries[]" value="<?php echo e($thread->id); ?>">
			<label class="control-label" for="entries"></label>
		</div>
	</div>
	
	<a href="<?php echo e(url('account/messages/' . $thread->id)); ?>" class="list-box-user">
		<img src="<?php echo e(url($thread->creator()->photo_url)); ?>" alt="<?php echo e($thread->creator()->name); ?>">
		<span class="name">
			<?php $userIsOnline = isUserOnline($thread->creator()) ? 'online' : 'offline'; ?>
			<i class="fa fa-circle <?php echo e($userIsOnline); ?>"></i> <?php echo e(\Illuminate\Support\Str::limit($thread->creator()->name, 14)); ?>

		</span>
	</a>
	<a href="<?php echo e(url('account/messages/' . $thread->id)); ?>" class="list-box-content">
		<span class="title"><?php echo e($thread->subject); ?></span>
		<div class="message-text">
			<?php echo e(\Illuminate\Support\Str::limit($thread->latest_message->body, 125)); ?>

		</div>
		<div class="time text-muted"><?php echo e($thread->created_at_formatted); ?></div>
	</a>
	
	<div class="list-box-action">
		<?php if($thread->isImportant()): ?>
			<a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsNotImportant')); ?>"
			   data-toggle="tooltip"
			   data-placement="top"
			   class="markAsNotImportant"
			   title="<?php echo e(t('Mark as not important')); ?>"
			>
				<i class="fas fa-star"></i>
			</a>
		<?php else: ?>
			<a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsImportant')); ?>"
			   data-toggle="tooltip"
			   data-placement="top"
			   class="markAsImportant"
			   title="<?php echo e(t('Mark as important')); ?>"
			>
				<i class="far fa-star"></i>
			</a>
		<?php endif; ?>
		<a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=delete')); ?>"
		   data-toggle="tooltip"
		   data-placement="top"
		   title="<?php echo e(t('Delete')); ?>"
		>
			<i class="fas fa-trash"></i>
		</a>
		<?php if($thread->isUnread()): ?>
			<a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsRead')); ?>"
			   class="markAsRead"
			   data-toggle="tooltip"
			   data-placement="top"
			   title="<?php echo e(t('Mark as read')); ?>"
			>
				<i class="fas fa-envelope"></i>
			</a>
		<?php else: ?>
			<a href="<?php echo e(url('account/messages/' . $thread->id . '/actions?type=markAsUnread')); ?>"
			   class="markAsRead"
			   data-toggle="tooltip"
			   data-placement="top"
			   title="<?php echo e(t('Mark as unread')); ?>"
			>
				<i class="fas fa-envelope-open"></i>
			</a>
		<?php endif; ?>
	</div>
</div><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/threads/thread.blade.php ENDPATH**/ ?>