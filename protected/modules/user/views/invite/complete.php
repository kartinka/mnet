<div id="content">
    <div class="row">
        <?php if(Yii::app()->user->hasFlash('inviteComplete')): ?>
            <div class="success">
                <?php echo Yii::app()->user->getFlash('inviteComplete'); ?>
            </div>
        <?php endif; ?>
    </div> <!-- row -->
</div> <!-- content -->