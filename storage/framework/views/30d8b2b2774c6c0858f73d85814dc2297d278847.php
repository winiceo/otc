<?php if(Session::has('success')): ?>
    <?php $__env->startComponent('components.alerts.dismissible', ['type' => 'success']); ?>
      <?php echo e(Session::get('success')); ?>

    <?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php if(Session::has('errors')): ?>
    <?php $__env->startComponent('components.alerts.dismissible', ['type' => 'danger']); ?>
        <?php if($errors->count() > 1): ?>
            <?php echo e(trans_choice('validation.errors', $errors->count())); ?>

            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <?php echo e($errors->first()); ?>

        <?php endif; ?>
    <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
