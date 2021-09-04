<div class="row payment-plugin" id="offlinePayment" style="display: none;">
    <div class="col-xs-12 col-md-8 box-center center">
		
        <img class="img-responsive box-center center" src="<?php echo e(url('images/offlinepayment/payment.png')); ?>" title="<?php echo e(trans('offlinepayment::messages.Offline Payment')); ?>" style="margin-bottom: 20px;">
        
        <div id="offlinePaymentDescription">
			<h3><strong><?php echo e(trans('offlinepayment::messages.Follow the information below to make the payment')); ?>:</strong></h3>
			<ul>
				<li>
					<strong><?php echo e(trans('offlinepayment::messages.Reason for payment')); ?>: </strong>
					<?php echo e(trans('offlinepayment::messages.Ad')); ?> #<?php echo e($post->id); ?> - <span class="package-name"></span>
				</li>
				<li>
					<strong><?php echo e(trans('offlinepayment::messages.Amount')); ?>: </strong>
					<span class="amount-currency currency-in-left" style="display: none;"></span>
					<span class="payable-amount">0</span>
					<span class="amount-currency currency-in-right" style="display: none;"></span>
				</li>
			</ul>
			<hr>
			
        	<?php echo (isset($offlinepaymentPaymentMethod)) ? $offlinepaymentPaymentMethod->description : ''; ?>

        </div>
        
    </div>
</div>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
    <script>
        $(document).ready(function ()
        {
            var selectedPackage = $('input[name=package_id]:checked').val();
			var packageName = $('input[name=package_id]:checked').data('name');
            var packagePrice = getPackagePrice(selectedPackage);
            var paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
    
            /* Check Payment Method */
            checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            
            $('#paymentMethodId').on('change', function () {
                paymentMethod = $(this).find('option:selected').data('name');
                checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            });
            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
				packageName = $(this).data('name');
                packagePrice = getPackagePrice(selectedPackage);
                paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
                checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            });
    
            /* Send Payment Request */
            $('#submitPostForm').on('click', function (e)
            {
                e.preventDefault();
        
                paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
                
                if (paymentMethod != 'offlinepayment' || packagePrice <= 0) {
                    return false;
                }
    
                $('#postForm').submit();
        
                /* Prevent form from submitting */
                return false;
            });
        });

        function checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice)
        {
            if (paymentMethod == 'offlinepayment' && packagePrice > 0) {
            	$('#offlinePaymentDescription').find('.package-name').html(packageName);
                $('#offlinePayment').show();
            } else {
                $('#offlinePayment').hide();
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/extras/plugins/offlinepayment/resources/views/offlinepayment.blade.php ENDPATH**/ ?>