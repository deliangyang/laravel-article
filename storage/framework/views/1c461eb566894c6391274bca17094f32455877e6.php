<?php $__env->startSection("content"); ?>

    <div class="alert alert-success" role="alert">
        下面是搜索"<?php echo e($query); ?>"出现的文章，共<?php echo e($posts->total()); ?>条
    </div>

    <div class="col-sm-8 blog-main">
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="/posts/<?php echo e($post->id); ?>" ><?php echo e($post->title); ?></a></h2>
                <p class="blog-post-meta"><?php echo e($post->created_at->toFormattedDateString()); ?> by <a href="#">Mark</a></p>

                <p><?php echo str_limit($post->content, 200, '...'); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo e($posts->links()); ?>

    </div><!-- /.blog-main -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>