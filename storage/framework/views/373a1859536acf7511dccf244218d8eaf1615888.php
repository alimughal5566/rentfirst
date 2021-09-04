<?php if(auth()->id() == $message->user->id): ?>
    <div class="chat-item object-me">
        <div class="chat-item-content">
            <div class="msg" style="padding-bottom: 10px">
                <?php if(isset($message->giftMessage->msg_id)): ?>
                    <?php if($message->giftMessage->msg_id == $message->id): ?>
                        <h5 style="background-color: white;padding: 5px; text-align: center; margin-bottom: 5px; border-radius: 8px; color: black ">You sent an offer</h5>

                        <p style="margin-bottom: 1px"><?php echo e($message->body); ?></p>
                        <?php if($message->giftMessage->status == 0): ?> <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: red !important; " class="btn btn-danger">Pending</span>
                        <?php endif; ?>
                        <?php if($message->giftMessage->status == 1): ?> <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: green !important; " class="btn">Accepted</span>
                        <?php endif; ?>
                        <?php if($message->giftMessage->status == 2): ?> <br>
                            <span style="padding: 5px; width: 100%; border-radius: 8px; background-color: white; color: red !important; " class="btn">Rejected</span>
                        <?php endif; ?>
                        <?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
                            <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                            <div class="<?php echo e($mt2Class); ?>">
                                <i class="fas fa-paperclip" aria-hidden="true"></i>
                                <a class="text-light"
                                   href="<?php echo e(fileUrl($message->filename)); ?>"
                                   target="_blank"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="<?php echo e(basename($message->filename)); ?>"
                                >
                                    <?php echo e(\Illuminate\Support\Str::limit(basename($message->filename), 20)); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo createAutoLink(nlToBr($message->body), ['class' => 'text-light']); ?>

                    <?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
                        <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                        <div class="<?php echo e($mt2Class); ?>">
                            <i class="fas fa-paperclip" aria-hidden="true"></i>
                            <a class="text-light"
                               href="<?php echo e(fileUrl($message->filename)); ?>"
                               target="_blank"
                               data-toggle="tooltip"
                               data-placement="left"
                               title="<?php echo e(basename($message->filename)); ?>"
                            >
                                <?php echo e(\Illuminate\Support\Str::limit(basename($message->filename), 20)); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <span class="time-and-date">
				<?php echo e($message->created_at_formatted); ?>

                <?php $recipient = $message->recipients()->first(); ?>
                <?php if(!empty($recipient) && !$message->thread->isUnread($recipient->user_id)): ?>
                    &nbsp;<i class="fas fa-check-double"></i>
                <?php endif; ?>
			</span>
        </div>
    </div>
<?php else: ?>
    <div class="chat-item object-user">
        <div class="object-user-img">
            <a href="<?php echo e(\App\Helpers\UrlGen::user($message->user)); ?>">
                <img src="<?php echo e(url($message->user->photo_url)); ?>" alt="<?php echo e($message->user->name); ?>">
            </a>
        </div>
        <div class="chat-item-content">
            <div class="chat-item-content-inner">
                <div class="msg bg-white" style="padding-bottom: 10px">
                    <?php if(isset($message->giftMessage->msg_id)): ?>
                        <?php if($message->giftMessage->msg_id == $message->id): ?>
                            <h5 style="background-color: #4682b4;padding: 5px; margin-bottom: 5px; border-radius: 8px; color: white "><?php echo e($message->giftMessage->user->name); ?> made an offer</h5>
                            <p style="margin-bottom: 0px"><?php echo createAutoLink(nlToBr($message->body)); ?></p>
                            <?php if($message->giftMessage->status == 0): ?> <br>
                                <a href="<?php echo e(route('accept_offer',[$message->giftMessage->id])); ?>" style="background-color: #4682b4; color: white; padding: 5px; border-radius: 8px">Accept</a>
                                <a href="<?php echo e(route('reject_offer',[$message->giftMessage->id])); ?>" style="background-color: red; color: white; padding: 5px; border-radius: 8px">Reject</a>
                            <?php endif; ?>
                            <?php if($message->giftMessage->status == 1): ?> <br>
                                <span style="padding: 5px; width: 100%; width: 100%; border-radius: 8px; background-color: white; color: green !important; border: 1px solid green;" >You Accepted</span>
                            <?php endif; ?>
                            <?php if($message->giftMessage->status == 2): ?> <br>
                                <span style="padding: 5px; width: 100%; width: 100%; border-radius: 8px; background-color: white; color: red !important; border: 1px solid red;" >You Rejected</span>
                            <?php endif; ?>
                            <?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
                                <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                                <div class="<?php echo e($mt2Class); ?>">
                                    <i class="fas fa-paperclip" aria-hidden="true"></i>
                                    <a class="text-light"
                                       href="<?php echo e(fileUrl($message->filename)); ?>"
                                       target="_blank"
                                       data-toggle="tooltip"
                                       data-placement="left"
                                       title="<?php echo e(basename($message->filename)); ?>"
                                    >
                                        <?php echo e(\Illuminate\Support\Str::limit(basename($message->filename), 20)); ?>

                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo createAutoLink(nlToBr($message->body)); ?>

                        <?php if(!empty($message->filename) and $disk->exists($message->filename)): ?>
                            <?php $mt2Class = !empty(trim($message->body)) ? 'mt-2' : ''; ?>
                            <div class="<?php echo e($mt2Class); ?>">
                                <i class="fas fa-paperclip" aria-hidden="true"></i>
                                <a class="text-light"
                                   href="<?php echo e(fileUrl($message->filename)); ?>"
                                   target="_blank"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="<?php echo e(basename($message->filename)); ?>"
                                >
                                    <?php echo e(\Illuminate\Support\Str::limit(basename($message->filename), 20)); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
















                </div>
                <?php $userIsOnline = isUserOnline($message->user); ?>
                <span class="time-and-date ml-0">
					<?php if($userIsOnline): ?>
                        <i class="fa fa-circle color-success"></i>&nbsp;
                    <?php endif; ?>
                    <?php echo e($message->created_at_formatted); ?>

				</span>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/messages/message.blade.php ENDPATH**/ ?>