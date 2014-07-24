<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change Password"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>

<div class="row">
    <h1><?php echo UserModule::t("Change password"); ?></h1>
    <br />

    <div class="span7">
            <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'changepassword-form',
                'enableAjaxValidation'=>false,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'well form-horizontal'),
            )); ?>

                <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

                <div class="control-group">
                    <div class="control-label">
                        <?php echo $form->labelEx($model,'password'); ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->passwordField($model,'password'); ?>
                        <?php echo $form->error($model,'password', array('class'=>'help-block error')); ?>
                        <p class="hint">
                            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
                        </p>
                    </div>
                </div>

                <div class="control-group">
                    <div class="control-label">
                        <?php echo $form->labelEx($model,'verifyPassword'); ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->passwordField($model,'verifyPassword'); ?>
                        <?php echo $form->error($model,'verifyPassword', array('class'=>'help-block error')); ?>
                    </div>
                </div>

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
                <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item active"><i class="icon-chevron-left"></i> Change Password</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item">Update Profile Picture</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item">Email Preferences</a>
                <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item">Feed Settings</a>
            </div>
        </div>
</div>