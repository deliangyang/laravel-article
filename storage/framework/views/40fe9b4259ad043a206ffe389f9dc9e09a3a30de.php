<?php if($target_user->id != \Auth::id()): ?>
    <div>
        <?php if($target_user->hasFan(\Auth::id())): ?>
            <button class="btn btn-default like-button" like-value="1" like-user="<?php echo e($target_user->id); ?>" _token="<?php echo e(csrf_token()); ?>" type="button">取消关注</button>
        <?php else: ?>
            <button class="btn btn-default like-button" like-value="0" like-user="<?php echo e($target_user->id); ?>" _token="<?php echo e(csrf_token()); ?>" type="button">关注</button>
        <?php endif; ?>
    </div>
<?php endif; ?>

