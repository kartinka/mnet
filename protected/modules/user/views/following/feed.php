<h1><?php echo UserModule::t('Feed settings'); ?></h1>
<br />

<div id="content">
    <div class="row">
        <div class="span7">
            <ul class="nav nav-tabs">
                <li class="<?php print ($title == 'topic')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/following/topicfeed">Topics</a></li>
                <li class="<?php print ($title == 'people')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/following/peoplefeed">People</a></li>
                <li class="<?php print ($title == 'question')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/following/questionfeed">Questions</a></li>
            </ul>

            <?php


                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$data,
                    'summaryText'=>'',
                    'ajaxUpdate'=>false,
                    'itemView'=>  '_' .$title,   // refers to the partial view named '_post'
                ));
            ?>
        </div> <!-- span7 Left Pane -->

        <div class="span4 offset1">
            <div class="list-group">
                <a href="<?php echo Yii::app()->baseUrl?>/user/user/view/id/me" class="list-group-item"> My profile </a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/profile/edit" class="list-group-item">Edit Account details</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item">Change Password</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item">Update Profile Picture</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item">Email Preferences</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item active"><i class="icon-chevron-left"></i> Feed Settings</a>
            </div>
        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->