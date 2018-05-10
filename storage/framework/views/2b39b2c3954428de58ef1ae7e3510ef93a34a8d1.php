<?php $__env->startSection("content"); ?>
    <div class="col-sm-8 blog-main">
        <?php echo $__env->make("post.carousel", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div style="height: 20px;">
        </div>
        <div>
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="/posts/<?php echo e($post->id); ?>" ><?php echo e($post->title); ?></a></h2>
                <p class="blog-post-meta"><?php echo e($post->created_at->toFormattedDateString()); ?> by <a href="/user/<?php echo e($post->user_id); ?>"><?php echo e($post->user->name); ?></a></p>

                <?php echo str_limit($post->content, 100, '...'); ?>

                <p class="blog-post-meta">赞 <?php echo e($post->zans_count); ?>  | 评论 <?php echo e($post->comments_count); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php echo e($posts->links()); ?>

        </div><!-- /.blog-main -->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>