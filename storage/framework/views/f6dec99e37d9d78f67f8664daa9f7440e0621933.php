<h1><?php echo app('translator')->getFromJson('newsletter.email.welcome'); ?></h1>

<p>
    <?php echo app('translator')->getFromJson('newsletter.email.description', ['count' => $posts->count()]); ?> :
</p>

<ul>
    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e(link_to_route('posts.show', $post->title, $post)); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<p>
    <?php echo app('translator')->getFromJson('newsletter.email.thanks'); ?>
</p>

<p>
    <?php echo e(link_to_route('newsletter-subscriptions.unsubscribe', __('newsletter.email.unsubscribe'), ['email' => $email])); ?>

</p>
