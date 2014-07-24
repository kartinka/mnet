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
?><h1><?php echo UserModule::t('Update Profile Picture'); ?></h1>
<br />
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="span7">

        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'uploadpicture-form',
                'enableAjaxValidation'=>false,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'well form-horizontal'),
            )); ?>
            <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
            <div class="control-group">
                    <div class="controls">
                        <?php
                            $profile_picture = (!empty($model->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$model->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg');
                            echo CHtml::image($profile_picture,'Profile Picture',
                                            array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;'));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <?php
                            echo $form->fileField($model, 'profile_picture');
                            echo $form->error($model, 'profile_picture');
                        ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton('Upload', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
                </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->

	</div>

    <div class="span4 offset1">
        <div class="list-group">
            <a href="<?php echo Yii::app()->baseUrl?>/user/user/view/id/me" class="list-group-item active"> My profile </a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/edit" class="list-group-item">Edit Account details</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item">Change Password</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item active"><i class="icon-chevron-left"></i> Update Profile Picture</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item">Email Preferences</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item">Feed Settings</a>
        </div>
    </div>
</div>

