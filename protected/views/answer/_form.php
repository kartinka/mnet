<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answer-form',
    'action'=> Yii::app()->baseUrl.'/answer/create',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'enableClientValidation'=>true,
	'enableAjaxValidation'=>true,
)); ?>
    <?php echo CHtml::label('Answer Question:', false); ?>

    <?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo (!$model->isNewRecord)? $form->hiddenField($model,'id',array('size'=>20,'maxlength'=>20)): ''; ?>
	</div>
    <?php echo CHtml::activehiddenField($model, 'q_id', array('value' => $q_id)); ?>
    <?php echo CHtml::activehiddenField($model, 'author_id', array('value' => Yii::app()->user->id)); ?>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'text'); ?>
        </div>
        <div class="controls">
            <?php $this->widget('application.extensions.tinymce.ETinyMce',
                array(
                    'model'=>$model,
                    'attribute'=>'text',
                    //'editorTemplate'=>'full',
                    'skin'=>'cirkuit',
                    'useSwitch' => false,
                    'useCompression'=>false,
                    'options'=> array(
                        'mode' =>"textareas",
                        'theme' => 'advanced',
                        'skin' => 'cirkuit',
                        'theme_advanced_toolbar_location'=>'top',
                        'plugins' => 'spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,template',
                        'theme_advanced_buttons1' => 'formatselect,fontsizeselect,forecolor,|,bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,spellchecker',
                        'theme_advanced_buttons2' => '',
                        'theme_advanced_buttons3' => '',
                        'theme_advanced_toolbar_location' => 'top',
                        'theme_advanced_toolbar_align' => 'left',
                        'theme_advanced_statusbar_location' => 'bottom',
                        'theme_advanced_resizing_min_height' => 30,
                        'height' => 300
                    ),
                    'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
                )); ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </div>
    <br>


    <div class="row buttons" align="right">
        <?php echo CHtml::htmlButton('Add Answer', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

