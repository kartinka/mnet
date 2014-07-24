<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Update Profile Picture");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?><h1><?php echo UserModule::t('Email Preferences'); ?></h1>
<br />

<div class="row">
    <div class="span7">
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'notifications-form',
                'enableAjaxValidation'=>false,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'well form-horizontal'),
            )); ?>
                <h3><?php echo UserModule::t('Choose when to receive email notifications'); ?></h3>
                <br />

                        <label class="checkbox" for="UserNotifications_follow_me">
                            <?php echo CHtml::activeCheckBox($model,'follow_me') . $form->label($model,'follow_me'); ?>
                        </label>

                        <label class="checkbox" for="UserNotifications_comment_on_question">
                            <?php echo CHtml::activeCheckBox($model,'comment_on_question') . $form->label($model,'comment_on_question'); ?>
                        </label>

                        <label class="checkbox" for="UserNotifications_answer_to_question">
                            <?php echo CHtml::activeCheckBox($model,'answer_to_question') . $form->label($model,'answer_to_question'); ?>
                        </label>

                        <label class="checkbox" for="UserNotifications_vote_on_answer">
                            <?php echo CHtml::activeCheckBox($model,'vote_on_answer') . $form->label($model,'vote_on_answer'); ?>
                        </label>

                        <label class="checkbox" for="UserNotifications_private_message">
                            <?php echo CHtml::activeCheckBox($model,'private_message') . $form->label($model,'private_message'); ?>
                        </label>

                        <label class="checkbox" for="UserNotifications_newsletter_sent">
                            <?php echo CHtml::activeCheckBox($model,'newsletter_sent') . $form->label($model,'newsletter_sent'); ?>
                        </label>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> ' . 'Save', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

	</div>

    <div class="span4 offset1">
        <div class="list-group">
            <a href="<?php echo Yii::app()->baseUrl?>/user/user/view/id/me" class="list-group-item active"> My profile </a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/edit" class="list-group-item">Edit Account details</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item">Change Password</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item">Update Profile Picture</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item active"><i class="icon-chevron-left"></i> Email Preferences</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item">Feed Settings</a>
        </div>
    </div>
</div>

