    <div class="span2">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?php echo ($active == 'inbox')? 'active':'' ?>"><a href="<?php echo $this->createUrl('inbox/') ?>">Inbox
                <?php if (Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId())): ?>
                    (<?php echo Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->getId()); ?>)
                <?php endif; ?>
            </a></li>
            <li class="<?php echo ($active == 'sent')? 'active':'' ?>"><a href="<?php echo $this->createUrl('sent/sent') ?>">Sent</a></li>
            <li class="<?php echo ($active == 'compose')? 'active':'' ?>"><a href="<?php echo $this->createUrl('compose/') ?>">Compose</a></li>
        </ul>

        <?php if(Yii::app()->user->hasFlash('messageModule')): ?>
            <div class="success">
                <?php echo Yii::app()->user->getFlash('messageModule'); ?>
            </div>
        <?php endif; ?>
    </div>