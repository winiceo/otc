<?php $__env->startSection('title', '后台管理'); ?>

<?php $__env->startSection('head'); ?>

    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##

    <script>
        window.TS = <?php echo json_encode([

                'api'       => $api,
                'baseURL'   => $base_url,
                'csrfToken' => $csrf_token,
                'logged'    => $logged,
                'user'      => $user,
                'token'     => $token,

            ]); ?>;
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>

    <div id="app"></div>


    <script src="<?php echo e(mix('web/js/manifest.js', 'assets')); ?>"></script>
    <script src="<?php echo e(mix('web/js/vendor.js', 'assets')); ?>"></script>
    ##parent-placeholder-02083f4579e08a612425c0c1a17ee47add783b94##
    <script src="<?php echo e(mix('js/admin.js', 'assets')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bootstrap', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>