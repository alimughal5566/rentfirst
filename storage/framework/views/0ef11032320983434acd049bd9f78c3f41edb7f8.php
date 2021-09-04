<?php if($paginator->hasPages()): ?>
    
    <?php if($paginator->hasMorePages()): ?>
        <span class="text-muted">
            <a class="btn btn-sm btn-secondary rounded mb-3" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                <?php echo e(t('Load old messages')); ?>

            </a>
        </span>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/messages/pagination.blade.php ENDPATH**/ ?>