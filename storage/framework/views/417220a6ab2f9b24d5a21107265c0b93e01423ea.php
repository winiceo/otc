<?php $__env->startSection('content'); ?>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1><?php echo app('translator')->getFromJson('auth.register'); ?></h1>

        <?php echo Form::open(['route' => 'register', 'role' => 'form', 'method' => 'POST']); ?>

            <div class="form-group">
                <?php echo Form::label('username', __('validation.attributes.name'), ['class' => 'control-label']); ?>

                <?php echo Form::text('username', old('username'), ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'required', 'autofocus']); ?>


                <?php if($errors->has('username')): ?>
                    <span class="invalid-feedback"><?php echo e($errors->first('username')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php echo Form::label('email', __('validation.attributes.email'), ['class' => 'control-label']); ?>

                <?php echo Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required']); ?>


                <?php if($errors->has('email')): ?>
                    <span class="invalid-feedback"><?php echo e($errors->first('email')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php echo Form::label('password', __('validation.attributes.password'), ['class' => 'control-label']); ?>

                <?php echo Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'required']); ?>


                <?php if($errors->has('password')): ?>
                    <span class="invalid-feedback"><?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php echo Form::label('password_confirmation', __('validation.attributes.password_confirmation'), ['class' => 'control-label']); ?>

                <?php echo Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'required']); ?>


                <?php if($errors->has('password_confirmation')): ?>
                    <span class="invalid-feedback"><?php echo e($errors->first('password_confirmation')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php echo Form::submit(__('auth.register'), ['class' => 'btn btn-primary']); ?>

            </div>

        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>