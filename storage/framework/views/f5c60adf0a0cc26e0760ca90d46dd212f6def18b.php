<?php if(isset($cats) && $cats->count() > 0): ?>
    <div class="container hide-xs">
        <div>
            <ul class="list-inline">
                <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-inline-item mt-2">
                        <?php if(isset($cat) && !empty($cat) and $iCat->id == $cat->id): ?>
                            <span class="badge badge-primary">
								<?php echo e($iCat->name); ?>

							</span>
                        <?php else: ?>
                            <a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>"
                               class="badge badge-light">
                                <?php echo e($iCat->name); ?>

                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/search/inc/categories-root.blade.php ENDPATH**/ ?>