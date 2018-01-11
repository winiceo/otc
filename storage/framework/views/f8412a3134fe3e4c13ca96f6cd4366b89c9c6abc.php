<?php $__env->startComponent('mail::message'); ?>

<?php if($user): ?>
**<?php echo e($user->name); ?>, 你好，**
<?php else: ?>
**你好，**
<?php endif; ?>

您此次申请的的验证码为 `<?php echo e($model->code); ?>` ，请在 30 分钟内输入验证码进行下一步操作。<br>
如非你本人操作，请忽略此邮件。

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
