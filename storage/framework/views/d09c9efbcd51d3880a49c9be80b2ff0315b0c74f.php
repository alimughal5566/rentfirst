<!-- Category -->
<div id="catsList">
	<div class="block-title has-arrow sidebar-header">
		<h5>
			<span class="font-weight-bold">
				<?php echo e(t('all_categories')); ?>

			</span>
		</h5>
	</div>
	<div class="block-content list-filter categories-list">
		<ul class="list-unstyled">
			<?php if(isset($cats) && $cats->count() > 0): ?>
				<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<?php if(isset($cat) && !empty($cat) && $iCat->id == $cat->id): ?>
							<strong>
								<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>" title="<?php echo e($iCat->name); ?>">
									<span class="title"><?php echo e($iCat->name); ?></span>
									<?php if(config('settings.listing.count_categories_posts')): ?>
										<span class="count">&nbsp;<?php echo e($countPostsByCat->get($iCat->id)->total ?? 0); ?></span>
									<?php endif; ?>
								</a>
							</strong>
						<?php else: ?>
							<a href="<?php echo e(\App\Helpers\UrlGen::category($iCat, null, $city ?? null)); ?>" title="<?php echo e($iCat->name); ?>">
								<span class="title"><?php echo e($iCat->name); ?></span>
								<?php if(config('settings.listing.count_categories_posts')): ?>
									<span class="count">&nbsp;<?php echo e($countPostsByCat->get($iCat->id)->total ?? 0); ?></span>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</ul>
	</div>
</div><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/search/inc/sidebar/categories/root.blade.php ENDPATH**/ ?>