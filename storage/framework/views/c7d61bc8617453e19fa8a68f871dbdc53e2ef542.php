<?php
// Fix: 404 error page don't know language and country objects.
$countryCode = 'us';
/* @fixme - Issue only in multi-countries mode. Get the real default country. */
$searchUrl = \App\Helpers\UrlGen::search();
?>
<div class="h-spacer"></div>
<div class="container">
    <div class="intro rounded-bottom">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container text-center">

                    <div class="search-row fadeInUp">
                        <form id="seach" name="search" action="<?php echo e($searchUrl); ?>" method="GET">
                            <div class="row m-0 justify-content-center justify-content-md-around">
                                <div class="col-md-5 col-12 search-col relative locationicon search-location">
                                    <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                                        <i class="far fa-map-marker-alt"></i>
                                        <label for="locSearch" class="sr-only"></label>
                                        <input type="text" id="locSearch" name="location"
                                               class="form-control locinput input-rel searchtag-input has-icon"
                                               placeholder="<?php echo e(t('where')); ?>" value="">
                                        <input type="hidden" id="lSearch" name="l" value="">
                                    </div>
                                </div>

                                <div class="col-md-5 col-12 search-col relative search-keyword">
                                    <div class="px-2 w-100 position-relative d-flex align-items-center justify-content-center">
                                        <i class="far fa-search"></i>
                                        <label for="keyword" class="sr-only"></label>
                                        <input type="text" name="q" class="form-control has-icon" id="keyword"
                                               placeholder="<?php echo e(t('what')); ?>" value="">
                                    </div>
                                </div>

                                <div class="col-md-2 col-12 search-col search-button">
                                    <div class="mt-md-0 px-2 w-100 position-relative d-flex align-items-center justify-content-center justify-content-md-start">
                                        <button class="btn btn-primary btn-search btn-block">
                                            <i class="icon-search"></i><strong><?php echo e(t('find')); ?></strong>
                                        </button>
                                    </div>
                                </div>
                                <?php echo csrf_field(); ?>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/errors/layouts/inc/search.blade.php ENDPATH**/ ?>