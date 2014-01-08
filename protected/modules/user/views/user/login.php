<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="row">
    <div class="span5">
        <div class="login-leftpane">
            <img border="1" style="padding: 8px ;" align="ABSMIDDLE" src="<?php echo Yii::app()->baseUrl ?>/images/mednet_logo_300.png" alt="theMednet" />			</div>
    </div>
    <div class="span7">
        <div class="login-rightpane">
        <h3>Sign in to theMednet</h3>

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'verticalForm',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'errorMessageCssClass'=>'help-block error',
            'htmlOptions'=>array(
                 'class'=>'form form-vertical',
            ),

    )); ?>

            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username', $enableAjaxValidation=false); ?>

            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password', $enableAjaxValidation=false); ?>

            <label class="checkbox" for="UserLogin_rememberMe">
                <?php echo CHtml::activeCheckBox($model,'rememberMe') . ' Remember me next time'; ?>
            </label>
            <?php echo $form->error($model,'rememberMe'); ?>

            <?php echo CHtml::htmlButton('<i class="icon-ok"></i> ' . 'Submit', array('class'=>'btn', 'type'=>'submit')); ?>

    <?php $this->endWidget(); ?>
    <?php echo CHtml::link(UserModule::t("Forgot Password"), Yii::app()->baseUrl.Yii::app()->getModule('user')->recoveryUrl[0]); ?>
    <br /><br />
    Not a member? Apply <?php echo CHtml::link(UserModule::t("Here"), Yii::app()->baseUrl.Yii::app()->getModule('user')->registrationUrl[0]); ?>
    </div> <!-- right pane-->
</div><!-- row -->
