<?php $__env->startSection('content'); ?>

    <div class="container setting">
        <div class="row">
            
                
            

            <div class="col-md-12">
                <?php echo $__env->make('widgets.trade', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo e($adverts->links('pagination.default')); ?>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>