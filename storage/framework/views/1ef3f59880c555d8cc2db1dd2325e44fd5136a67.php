<div class="col-lg-6 col-md-12">
	<div class="card rounded shadow-sm">
		<div class="card-body">
			<div class="d-flex">
				<div>
					<h4 class="card-title mb-1 font-weight-bold">
						<span class="lstick d-inline-block align-middle"></span><?php echo e($latestUsersChart->title); ?>

					</h4>
				</div>
				<div class="ml-auto">
					<ul class="list-inline text-right">
						<li class="list-inline-item">
							<h5><i class="fa fa-circle mr-1" style="color: #398bf7;"></i><?php echo e(trans('admin.Activated')); ?></h5>
						</li>
						<li class="list-inline-item">
							<h5><i class="fa fa-circle mr-1" style="color: #dddddd;"></i><?php echo e(trans('admin.Unactivated')); ?></h5>
						</li>
					</ul>
				</div>
			</div>
			<div id="barChartUsers" class="position-relative" style="height:300px;"></div>
		</div>
	</div>
</div>

<?php $__env->startPush('dashboard_styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('dashboard_scripts'); ?>
    <script>
        $(function () {
            "use strict";
			
			/* Users Chart */
            var barChartUsers = new Morris.Bar({
                element: 'barChartUsers',
				barGap: 0,
                resize: true,
                data: <?php echo $latestUsersChart->data; ?>,
                xkey: 'y',
                ykeys: ['activated', 'unactivated'],
                labels: ['<?php echo e(trans('admin.Activated')); ?>', '<?php echo e(trans('admin.Unactivated')); ?>'],
				gridLineColor: '#e0e0e0',
				barColors: ['#398bf7', '#dddddd'],
                hideHover: 'auto',
                parseTime: false
            });
			
			let alreadyRedrawn = false;
			let haveToResizeCharts = false;
			$(window).resize(function() {
				haveToResizeCharts = true;
			});
			setInterval(function() {
				if (barChartUsers) {
					if (!alreadyRedrawn) {
						barChartUsers.redraw();
						alreadyRedrawn = true;
					}
					if (haveToResizeCharts) {
						barChartUsers.redraw();
						haveToResizeCharts = false;
					}
				}
			}, 200);
			
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/vendor/admin/dashboard/inc/charts/morris/bar/latest-users.blade.php ENDPATH**/ ?>