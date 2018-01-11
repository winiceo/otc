<?php if($paginator->hasPages()): ?>


<div class="text-center">

    <nav aria-label="Page navigation example">

        <ul class="pagination  ">

            <?php if($paginator->onFirstPage()): ?>
                <li class=" page-item ">
                    <span class="page-link"   aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </span>
                 </li>
            <?php else: ?>

                <li class="page-item ">

                    <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>

                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>

                    <li class="page-item  ">
                        <span class="page-link"><?php echo e($element); ?></span>


                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active">
                                <span class="page-link"  ><?php echo e($page); ?></span>
                            </li>
                         <?php else: ?>
                             <li class="page-item ">
                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item ">
                    <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                 </li>
            <?php else: ?>
                <li class="page-item disabled">
                         <span  ><i class="fa fa-angle-double-right"  ></i></span>
                 </li>
             <?php endif; ?>


        </ul>
    </nav>



</div>
<?php endif; ?>
