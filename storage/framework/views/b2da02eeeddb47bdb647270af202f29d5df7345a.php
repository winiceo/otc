<?php $__env->startSection('head'); ?>
    
    ##parent-placeholder-1a954628a960aaef81d7b2d4521929579f3541e6##

    <style type="text/css">
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 36px;
            padding: 20px;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title">

                <?php echo e($exception->getMessage()); ?>


            </div>
        </div>
    </div>

    ##parent-placeholder-02083f4579e08a612425c0c1a17ee47add783b94##

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bootstrap', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>