<div class="container">
	<?php if(Session::has('message') && isset($showmsg)): ?>
		<p class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?>"><?php echo e(Session::get('message')); ?></p>
	<?php endif; ?>
</div>
<?php if(isset($packages, $paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0): ?>
	<div class="well pb-0">
		<h3><i class="icon-certificate icon-color-1"></i> <?php echo e(t('Premium Ad')); ?> </h3>
		<p>
			<?php echo e(t('premium_plans_hint')); ?>

		</p>
		<?php $packageIdError = (isset($errors) and $errors->has('package_id')) ? ' is-invalid' : ''; ?>
		<div class="form-group mb-0">
			<table id="packagesTable" class="table table-hover checkboxtable mb-0">
				<?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$packageStatus = '';
					$badge = '';
					if (isset($currentPackageId, $currentPackagePrice, $currentPaymentActive)) {
						// Prevent Package's Downgrading
						if ($currentPackagePrice > $package->price) {
							$packageStatus = ' disabled';
							$badge = ' <span class="badge badge-danger">' . t('Not available') . '</span>';
						} elseif ($currentPackagePrice == $package->price) {
							$badge = '';
						} else {
							if ($package->price > 0) {
								$badge = ' <span class="badge badge-success">' . t('Upgrade') . '</span>';
							}
						}
						if ($currentPackageId == $package->id) {
							$badge = ' <span class="badge badge-secondary">' . t('Current') . '</span>';
							if ($currentPaymentActive == 0) {
								$badge .= ' <span class="badge badge-warning">' . t('Payment pending') . '</span>';
							}
						}
					} else {
						if ($package->price > 0) {
							$badge = ' <span class="badge badge-success">' . t('Upgrade') . '</span>';
						}
					}
					?>
					<tr>
						<td class="text-left align-middle p-3">
							<div class="form-check">
								<input class="form-check-input package-selection<?php echo e($packageIdError); ?>"
									   type="radio"
									   name="package_id"
									   id="packageId-<?php echo e($package->id); ?>"
									   value="<?php echo e($package->id); ?>"
									   data-name="<?php echo e($package->name); ?>"
									   data-currencysymbol="<?php echo e($package->currency->symbol); ?>"
									   data-currencyinleft="<?php echo e($package->currency->in_left); ?>"
										 onchange="show_button(<?php echo e($currentPackageId); ?>)"
										<?php echo e((old('package_id', isset($currentPackageId) ? $currentPackageId : 0)==$package->id) ? ' checked' : (($package->price==0) ? ' checked' : '')); ?> <?php echo e($packageStatus); ?>

								>
								<label class="form-check-label mb-0<?php echo e($packageIdError); ?>">
									<strong class="tooltipHere"
											title=""
											data-placement="right"
											data-toggle="tooltip"
											data-original-title="<?php echo $package->description_string; ?>"
									><?php echo $package->name . $badge; ?> </strong>
								</label>
							</div>
						</td>
						<td class="text-right align-middle p-3">
							<p id="price-<?php echo e($package->id); ?>" class="mb-0">
								<?php if($package->currency->in_left == 1): ?>
									<span class="price-currency"><?php echo $package->currency->symbol; ?></span>
								<?php endif; ?>
								<span class="price-int"><?php echo e($package->price); ?></span>
								<?php if($package->currency->in_left == 0): ?>
									<span class="price-currency"><?php echo $package->currency->symbol; ?></span>
								<?php endif; ?>
							</p>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr><td><b>Purchase Post Limit Package: </b></td><td></td></tr>
				<tr>
					<td>Package Name</td>
					<td>Category Name</td>
					<td>Package Price</td>
				</tr>
				<tr>
					<td>
						<select class="form-control" name="limit_package_id" id="limit_package_id">
							<option value="" selected>Nothing Selected</option>
							<?php $__currentLoopData = $limit_pkgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($pkg->id); ?>"><?php echo e($pkg->name); ?> (<?php echo e($pkg->category->name); ?>)</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
					<td>
						<div id="pkg_cat_name">

						</div>
					</td>
					<td>
						<div id="pkg_cat_price">

						</div>
					</td>
				</tr>


				<tr>
					<td class="text-left align-middle p-3">
						<?php echo $__env->first([
							config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods',
							'post.createOrEdit.inc.payment-methods'
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</td>
					<td class="text-right align-middle p-3">
						<p class="mb-0">
							<strong>
								<?php echo e(t('Payable Amount')); ?>:
								<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
								<span class="payable-amount">0</span>
								<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
							</strong>
						</p>
					</td>
				</tr>

			</table>
		</div>
	</div>
	<script>
		$(document).on('change', '#limit_package_id',function(){
			var id = $('#limit_package_id').val()
			$.ajax({
				type: "get",
				data: {id: id},
				url: '<?php echo e(route('get_package_detail')); ?>',
				success: function (response) {
					console.log(response)
					var js = JSON.parse(response.package.category.name)
					$('#pkg_cat_name').text(js.en)
					$('#pkg_cat_price').text(response.package.price)
				}
			});
		});

	</script>

	<?php echo $__env->first([
		config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods.plugins',
		'post.createOrEdit.inc.payment-methods.plugins'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/post/createOrEdit/inc/packages.blade.php ENDPATH**/ ?>