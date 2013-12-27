<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'RegistrationForm',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'errorMessageCssClass'=>'help-block error',
    'htmlOptions'=>array(
        'class'=>'well form-horizontal',
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'username'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
	</div>

    <div class="control-group">
        <div class="control-label">
    		<?php echo $form->labelEx($model,'password'); ?>
        </div>
        <div class="controls">
            <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128, 'minlength'=>4)); ?>
            <p class="help-block">Minimal password length 4 symbols</p>
    		<?php echo $form->error($model,'password'); ?>
        </div>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'email'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'first_name'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'first_name'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->label($model,'middle_name'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'middle_name',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'middle_name'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'last_name'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->error($model,'last_name'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'specialty'); ?>
        </div>
        <div class="controls">
            <?php $specialties = array('Radiation Oncology'=>'Radiation Oncology');//CHtml::listData(Roles::model()->findAll(array('order' => 'ID')), 'ID', 'Name'); ?>
            <?php echo $form->dropDownList($model, 'specialty',$specialties); ?>
            <p class="help-block">Mednet is currently only available to Radiation Oncologists</p>
            <?php echo $form->error($model,'speciality'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->label($model,'invite_code'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'invite_code'); ?>
            <p class="help-block">Please enter invite code if available</p>
            <?php echo $form->error($model,'invite_code'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'institution'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'institution',array('size'=>60,'maxlength'=>150)); ?>
            <?php echo $form->error($model,'institution'); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> ' . 'Complete Registration', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
    </div>
	<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->