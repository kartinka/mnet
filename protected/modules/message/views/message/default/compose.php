<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Compose Message"); ?>
<?php
	$this->breadcrumbs=array(
		MessageModule::t("Messages"),
		MessageModule::t("Compose"),
	);
?>
<div class="row">
        <?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_navigation', array('active' => 'compose')); ?>

    <div class="span7 offset1">
        <h2><?php echo MessageModule::t('Compose New Message'); ?></h2>

        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'message-form',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                    'class'=>'well form-horizontal',
                ),

            )); ?>

            <p class="note"><?php echo MessageModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

            <?php echo $form->errorSummary($model); ?>

            <div class="control-group">
                <div class="control-label">
                    <?php echo $form->labelEx($model,'receiver_id'); ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::textField('receiver', $receiverName) ?>
                    <?php echo $form->hiddenField($model,'receiver_id'); ?>
                    <?php echo $form->error($model,'receiver_id'); ?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?php echo $form->labelEx($model,'subject'); ?>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model,'subject'); ?>
                    <?php echo $form->error($model,'subject'); ?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?php echo $form->labelEx($model,'body'); ?>
                </div>
                <div class="controls">
                    <?php echo $form->textArea($model,'body'); ?>
                    <?php echo $form->error($model,'body'); ?>
                </div>
            </div>

            <div class="form-actions">
                <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> ' . MessageModule::t("Send"), array('class'=>'btn btn-info', 'type'=>'submit')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div>

        <?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_suggest'); ?>
    </div>
</div>