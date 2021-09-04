<?php if(is_array(getSupportedLanguages()) && count(getSupportedLanguages()) > 1): ?>
	<!-- Language Selector -->
	<li class="dropdown lang-menu nav-item">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
			<span class="lang-title"><?php echo e(strtoupper(config('app.locale'))); ?></span>
		</button>
		<ul id="langMenuDropdown" class="dropdown-menu dropdown-menu-right user-menu shadow-sm" role="menu">
			<?php $__currentLoopData = getSupportedLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langCode => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(strtolower($langCode) == strtolower(config('app.locale'))) continue; ?>
				<li class="dropdown-item">
					<a href="<?php echo e(url('lang/' . $langCode)); ?>" tabindex="-1" rel="alternate" hreflang="<?php echo e($langCode); ?>">
						<span class="lang-name"><?php echo $lang['native']; ?></span>
					</a>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</li>
<?php endif; ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/layouts/inc/menu/select-language.blade.php ENDPATH**/ ?>