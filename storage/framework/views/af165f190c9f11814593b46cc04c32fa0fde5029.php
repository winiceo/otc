<?php if(session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo session()->pull('error'); ?>

    </div>
<?php endif; ?>

<?php if(session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo session()->pull('success'); ?>

    </div>
<?php endif; ?>
