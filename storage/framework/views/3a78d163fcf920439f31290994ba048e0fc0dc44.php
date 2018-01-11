<?php $__env->startSection('body'); ?>
    <div class="container">
        <?php echo $__env->make('layouts._alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="jumbotron text-center">
        <div class="logo"><img src="<?php echo e(asset('images/laravelio.png')); ?>" title="Laravel.io"></div>
        <h2>The Laravel Community Portal</h2>

        <div style="margin-top:40px">
          <?php echo e(__('site.home')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['bodyClass' => 'home'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>