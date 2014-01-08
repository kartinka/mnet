<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="row">
    <div class="span7 offset2">
        <h1><?php echo UserModule::t("Password Recovery"); ?></h1>
        <br />
        <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
        <?php else: ?>

        <div class="form">
        <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data', 'id'=>'UserRecoveryForm', 'class'=>'well form-horizontal')); ?>

            <div class="control-group">
                <div class="control-label">
                    <?php echo CHtml::activeLabelEx($form,'login_or_email'); ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::activeTextField($form,'login_or_email') ?>
                    <p class="help-block">Enter in email to begin recover process</p>
                    <?php echo CHtml::error($form, 'login_or_email', array('class'=>'help-block error')); ?>
                </div>
            </div>

            <div class="form-actions">
                <?php echo CHtml::submitButton(UserModule::t("Recover"), array('class'=>'btn btn-info')); ?>
            </div>

        <?php echo CHtml::endForm(); ?>
        </div><!-- form -->
        <?php endif; ?>
    </div>
</div>