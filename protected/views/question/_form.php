<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'question_text'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textArea($model,'question_text',array('rows'=>6, 'cols'=>30, 'style'=>'width: 98%')); ?>
		    <?php echo $form->error($model,'question_text'); ?>
        </div>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'question_detail'); ?>
        </div>
        <div class="controls">
            <?php $this->widget('application.extensions.tinymce.ETinyMce',
                array(
                    'model'=>$model,
                    'attribute'=>'question_detail',
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
        </div>
    </div>
    <br>
    <label class="checkbox" for="Question_question_anonymous">
        <?php echo CHtml::activeCheckBox($model,'question_anonymous', array('value'=>1, 'uncheckValue'=>0)) . ' Post anonymously'; ?>
    </label>
    <br>
        <i> If you'd like to make sure a particular person gets your question please select them from below. You can search by name, institution or specialty.</i>
        <br><br>
             <?php
                 $this->widget('application.components.widgets.tag.TagWidget', array(

                     'url'=> Yii::app()->request->baseUrl.'/tags/json/',
                     //'tags' => array('1', '2')//$model->getTags()
                 ));
             ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="row buttons" align="right">
    <?php echo CHtml::htmlButton('Add Images', array('class'=>'btn', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Post Question', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
</div>
