
        <!DOCTYPE html>
<html lang="<?php echo e(ietfLangTag(config('app.locale'))); ?>"<?php echo (config('lang.direction')=='rtl') ? ' dir="rtl"' : ''; ?>>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex">
    <link rel="shortcut icon" href="<?php echo e(imgUrl(config('settings.app.favicon'), 'favicon')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Common -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/normalize.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/animate.css')); ?>">

    <?php if(file_exists(public_path('manifest.json'))): ?>
        <link rel="manifest" href="/manifest.json">
    <?php endif; ?>

    <?php echo $__env->yieldContent('before_styles'); ?>

    <?php if(config('lang.direction') == 'rtl'): ?>
        <link href="https://fonts.googleapis.com/css?family=Cairo|Changa" rel="stylesheet">
        <link href="<?php echo e(url(mix('css/app.rtl.css'))); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(url(mix('css/app.css'))); ?>" rel="stylesheet">
    <?php endif; ?>
    <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.style', 'layouts.inc.tools.style'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(url('css/custom.css') . getPictureVersion()); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(url('https://pro.fontawesome.com/releases/v5.10.0/css/all.css')); ?>"/>

    <?php echo $__env->yieldContent('after_styles'); ?>

    <?php if(config('settings.style.custom_css')): ?>
        <?php echo printCss(config('settings.style.custom_css')) . "\n"; ?>

    <?php endif; ?>

    <?php if(config('settings.other.js_code')): ?>
        <?php echo printJs(config('settings.other.js_code')) . "\n"; ?>

    <?php endif; ?>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/common.css')); ?>?<?php echo e(time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/defaults.css')); ?>?<?php echo e(time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/main.css')); ?>?<?php echo e(time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/custom/responsive.css')); ?>?<?php echo e(time()); ?>">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script>
        paceOptions = {
            elements: true
        };
    </script>
    <script src="<?php echo e(url('assets/js/pace.min.js')); ?>"></script>
</head>
<body class="<?php echo e(config('settings.style.app_skin')); ?>">

<div id="wrapper">

    <?php $__env->startSection('header'); ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'errors.layouts.inc.header', 'errors.layouts.inc.header'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php $__env->startSection('search'); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php $__env->startSection('info'); ?>
    <?php echo $__env->yieldSection(); ?>

    <?php $__env->startSection('footer'); ?>
        <?php echo $__env->first([config('larapen.core.customizedViewPath') . 'errors.layouts.inc.footer', 'errors.layouts.inc.footer'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldSection(); ?>

</div>

<?php echo $__env->yieldContent('before_scripts'); ?>

<script>
            
    var siteUrl = '<?php echo e(url('/')); ?>';
    var languageCode = '<?php echo config('app.locale'); ?>';
    var countryCode = '<?php echo config('country.code', 0); ?>';

            
    var langLayout = {
            'hideMaxListItems': {
                'moreText': "<?php echo e(t('View More')); ?>",
                'lessText': "<?php echo e(t('View Less')); ?>"
            }
        };
</script>
<script src="<?php echo e(url(mix('js/app.js'))); ?>"></script>

<?php echo $__env->yieldContent('after_scripts'); ?>

<?php if(config('settings.footer.tracking_code')): ?>
    <?php echo printJs(config('settings.footer.tracking_code')) . "\n"; ?>

<?php endif; ?>
</body>
</html><?php /**PATH /home1/hasaanmalik/rentfirst.ivylabtech.com/resources/views/errors/layouts/master.blade.php ENDPATH**/ ?>