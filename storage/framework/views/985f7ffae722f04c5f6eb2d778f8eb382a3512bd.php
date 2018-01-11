<?php $__env->startSection('content'); ?>
    <div class="">
        <div class="usernewout">

            <div class="usncont">
                <!--左侧菜单-->
                <?php echo $__env->make('userad.particals.side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo $__env->yieldContent('userright'); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>