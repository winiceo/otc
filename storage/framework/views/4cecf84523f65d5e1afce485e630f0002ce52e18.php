<?php $__env->startSection('title', 'Plus ID'); ?>

<?php $__env->startSection('head'); ?>
    
    <meta name="admin-api-basename" content="<?php echo e(url('/genv/plus-id')); ?>">
    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##

<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>

    <div id="app"></div>
    ##parent-placeholder-02083f4579e08a612425c0c1a17ee47add783b94##
    <script src="<?php echo e(mix('app.js', 'assets/plus-id')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bootstrap', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>