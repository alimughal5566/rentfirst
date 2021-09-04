<?php if($paginator->hasPages()): ?>
    <div class="btn-group btn-group-sm">
        
        <?php if($paginator->onFirstPage()): ?>
            <button type="button" class="btn btn-secondary" aria-disabled="true">
                <span class="fas fa-arrow-left"></span>
            </button>
        <?php else: ?>
            <a class="btn btn-secondary" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                <span class="fas fa-arrow-left"></span>
            </a>
        <?php endif; ?>
    
        
        <?php if($paginator->hasMorePages()): ?>
            <a class="btn btn-secondary" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                <span class="fas fa-arrow-right"></span>
            </a>
        <?php else: ?>
            <button type="button" class="btn btn-secondary" aria-disabled="true">
                <span class="fas fa-arrow-right"></span>
            </button>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/messenger/threads/pagination.blade.php ENDPATH**/ ?>