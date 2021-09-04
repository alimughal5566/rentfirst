


<?php $__env->startSection('content'); ?>
	<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 page-sidebar">
					<?php echo $__env->first([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-md-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-money"></i> <?php echo e(t('Transactions')); ?> </h2>
						
						<div style="clear:both"></div>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
								<tr>
									<th><span>ID</span></th>
									<th><?php echo e(t('Description')); ?></th>
									<th><?php echo e(t('Payment Method')); ?></th>
									<th><?php echo e(t('Value')); ?></th>
									<th><?php echo e(t('Date')); ?></th>
									<th><?php echo e(t('Status')); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (isset($transactions) && $transactions->count() > 0):
									foreach($transactions as $key => $transaction):
										
										// Fixed 2
										if (empty($transaction->post)) continue;
										if (!$countries->has($transaction->post->country_code)) continue;
										
										if (empty($transaction->package)) continue;
								?>
								<tr>
									<td>#<?php echo e($transaction->id); ?></td>
									<td>
										<a href="<?php echo e(\App\Helpers\UrlGen::post($transaction->post)); ?>"><?php echo e($transaction->post->title); ?></a><br>
										<strong><?php echo e(t('type')); ?></strong> <?php echo e($transaction->package->short_name); ?> <br>
										<strong><?php echo e(t('Duration')); ?></strong> <?php echo e($transaction->package->duration); ?> <?php echo e(t('days')); ?>

									</td>
									<td>
										<?php if($transaction->active == 1): ?>
											<?php if(!empty($transaction->paymentMethod)): ?>
												<?php echo e(t('Paid by')); ?> <?php echo e($transaction->paymentMethod->display_name); ?>

											<?php else: ?>
												<?php echo e(t('Paid by')); ?> --
											<?php endif; ?>
										<?php else: ?>
											<?php echo e(t('Pending payment')); ?>

										<?php endif; ?>
									</td>
									<td><?php echo ((!empty($transaction->package->currency)) ? $transaction->package->currency->symbol : '') . '' . $transaction->package->price; ?></td>
									<td><?php echo $transaction->created_at_formatted; ?></td>
									<td>
										<?php if($transaction->active == 1): ?>
											<span class="badge badge-success"><?php echo e(t('Done')); ?></span>
										<?php else: ?>
											<span class="badge badge-info"><?php echo e(t('Pending')); ?></span>
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
						
						<nav aria-label="">
							<?php echo e((isset($transactions)) ? $transactions->links() : ''); ?>

						</nav>
						
						<div style="clear:both"></div>
					
					</div>
				</div>
				<!--/.page-content-->
				
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after_scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/account/transactions.blade.php ENDPATH**/ ?>