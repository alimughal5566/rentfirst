<?php if(isset($countryCode, $languageCode, $currSearch, $_token, $cities)): ?>
<div class="row">

	<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="col-md-4">
			<ul class="list-link list-unstyled">
				<?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($loop->parent->first and $loop->first): ?>
						<li><a href="<?php echo e(\App\Helpers\UrlGen::search()); ?>"><?php echo e(t('All Cities', [], 'global', $languageCode)); ?></a></li>
					<?php endif; ?>
					<?php
						$params = ['d' => config('country.icode'), 'l' => $city->id];
						$inputs = array_merge($currSearch, $params);
						$except = ['_token'];
						$url = \App\Helpers\UrlGen::search($inputs, $except);
					?>
					<li><a href="<?php echo e($url); ?>" title="<?php echo e($city->name); ?>"><?php echo e($city->name); ?></a></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	
</div>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/layouts/inc/modal/location/cities.blade.php ENDPATH**/ ?>