<?php $__env->startSection('head'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo e(mix('css/bootstrap.css', 'assets')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <script type="text/javascript" src="<?php echo e(mix('js/bootstrap.js', 'assets')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>