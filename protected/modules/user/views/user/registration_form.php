<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'RegistrationForm',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
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
            <?php echo $form->labelEx($model,'email'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'email'); ?>
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
            <?php echo $form->labelEx($model,'verifyPassword'); ?>
        </div>
        <div class="controls">
            <?php echo $form->passwordField($model,'verifyPassword'); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>
    </div>

<?php // fields from user profile
    $profileFields=$profile->getFields();
    if ($profileFields) {
        foreach($profileFields as $field) {
            ?>
            <div class="control-group">
                <div class="control-label">
                    <?php echo $form->labelEx($profile,$field->varname); ?>
                </div>
                <div class="controls">
                    <?php
                    if ($widgetEdit = $field->widgetEdit($profile)) {
                        echo $widgetEdit;
                    } elseif ($field->range) {
                        echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
                    } elseif ($field->field_type=="TEXT") {
                        echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50, 'class'=>$field->class));
                    } else {
                        echo $form->textField($profile,$field->varname,array('size'=>60, 'class'=>$field->class, 'maxlength'=>(($field->field_size)?$field->field_size:255)));
                    }
                    ?>
                    <?php echo $form->error($profile,$field->varname); ?>
                </div>

            </div>
        <?php
        }
    }
    ?>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($job,'location'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($job,'location',array('size'=>60, 'cols'=>30, 'maxlength'=>1000)); ?>
            <?php echo $form->error($job,'location'); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php //echo CHtml::submitButton(UserModule::t("Register")); ?>
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> ' . 'Complete Registration', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
    </div>
	<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->