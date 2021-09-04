<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->id : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
    $qLocationId = (isset($city->id)) ? $city->id : 0;
    $qLocation = $city->name;
    $qAdmin = request()->get('r');
} else {
    $qLocationId = request()->get('l');
    $qLocation = (request()->filled('r')) ? t('area') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>
<div class="container">
    <div class="search-row-wrapper bg-transparent">
        <div class="container">
            <form id="seach" name="search" action="<?php echo e(\App\Helpers\UrlGen::search()); ?>" method="GET">
                <div class="row m-0 d-flex justify-content-around">

                    <div class="col-md-3 col-12 search-col  search-cat">
                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                            <label for="catSearch" class="sr-only"></label>
                            <select name="c" id="catSearch" class="form-control selecter">
                                <option value="" <?php echo e(($qCategory=='') ? 'selected="selected"' : ''); ?>>
                                    <?php echo e(t('all_categories')); ?>

                                </option>
                                <?php if(isset($rootCats) and $rootCats->count() > 0): ?>
                                    <?php $__currentLoopData = $rootCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(($qCategory == $itemCat->id) ? ' selected="selected"' : ''); ?> value="<?php echo e($itemCat->id); ?>">
                                            <?php echo e($itemCat->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12 search-col search-keyword relative">
                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                            <i class="far fa-search"></i>
                            <label for="whatSearch" class="sr-only"></label>
                            <input name="q" id="whatSearch" class="form-control keyword" type="text"
                                   placeholder="<?php echo e(t('what')); ?>" value="<?php echo e($keywords); ?>">
                        </div>
                    </div>

                    <div class="col-md-3 col-12 search-col search-location locationicon relative">
                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">

                            <i class="far fa-map-marker-alt"></i>
                            <label for="locSearch" class="sr-only"></label>
                            <input type="text" id="locSearch" name="location"
                                   class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                   placeholder="<?php echo e(t('where')); ?>" value="<?php echo e($qLocation); ?>" title=""
                                   data-placement="bottom"
                                   data-toggle="tooltip"
                                   data-original-title="<?php echo e(t('Enter a city name OR a state name with the prefix', ['prefix' => t('area')]) . t('State Name')); ?>">
                        </div>
                    </div>

                    <input type="hidden" id="lSearch" name="l" value="<?php echo e($qLocationId); ?>">
                    <input type="hidden" id="rSearch" name="r" value="<?php echo e($qAdmin); ?>">

                    <div class="col-md-2 col-12 search-col search-button">
                        <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                            <button class="btn btn-primary btn-search d-flex align-items-center justify-content-center">
                                <strong><?php echo e(t('find')); ?></strong>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startSection('after_scripts'); ?>
    ##parent-placeholder-3bf5331b3a09ea3f1b5e16018984d82e8dc96b5f##
    <script>
        $(document).ready(function () {
            $('#locSearch').on('change', function () {
                if ($(this).val() == '') {
                    $('#lSearch').val('');
                    $('#rSearch').val('');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/search/inc/form.blade.php ENDPATH**/ ?>