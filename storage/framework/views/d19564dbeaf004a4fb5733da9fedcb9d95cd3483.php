<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(auth()->guard()->check()): ?>
        <meta name="api-token" content="<?php echo e(auth()->user()->api_token); ?>">
    <?php endif; ?>

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <script>

        window.App=<?php echo json_encode(leven(), 15, 512) ?>;
        window.Language = '<?php echo e(config('app.locale')); ?>';

        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>


          window.app=<?php echo json_encode($public, 15, 512) ?>;
    </script>

    <script>
        
            

                
                
                
                
                
                

            
        
    </script>
    <!-- Styles -->
    <link href="<?php echo e(asset('assets/web/css/app.css')); ?>" rel="stylesheet">

 </head>
<body class="bg-light">
    <div id="app">
        <?php echo $__env->make('shared/navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="container">
            <?php echo $__env->make('shared/alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="row">
                <div class="col-md-12">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>

        <?php echo $__env->make('shared/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <!-- Scripts -->
    <?php if(Request::is('posts/*')): ?>
        <script src="//<?php echo e(Request::getHost()); ?>:8888/socket.io/socket.io.js"></script>
    <?php endif; ?>

    <script src="<?php echo e(asset('assets/web/js/manifest.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/web/js/vendor.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/web/js/app.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('inline-scripts'); ?>
</body>
</html>
