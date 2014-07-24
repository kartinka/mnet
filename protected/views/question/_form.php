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
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, '', '', array('class' => 'flash-error')); ?>

    <?php if(Yii::app()->user->hasFlash('incorrectImage')): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('incorrectImage'); ?>
        </div>
    <?php endif; ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'topics'); ?>
        </div>
        <div class="controls">
            <?php //echo CHtml::dropDownList('topics', '', $topics); ?>
            <?php echo $form->dropDownList($model, 'topics', $topics);?>
        </div>
    </div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'text'); ?>
        </div>
        <div class="controls">
            <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>30, 'style'=>'width: 98%')); ?>
		    <?php echo $form->error($model,'text'); ?>
        </div>
	</div>

    <div class="control-group">
        <div class="control-label">
            <?php echo $form->labelEx($model,'detail'); ?>
        </div>
        <div class="controls">
            <?php $this->widget('application.extensions.tinymce.ETinyMce',
                array(
                    'model'=>$model,
                    'attribute'=>'detail',
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

    <label class="checkbox" for="question_anonymous">
        <?php echo CHtml::checkBox('question_anonymous', ($model->author_id == -1)? true: false) . ' Post anonymously'; ?>
    </label>
    <br>
        <i> If you'd like to make sure a particular person gets your question please select them from below. You can search by name or username.</i>
        <br><br>
        <div class="controls">
            <?php echo CHtml::textField('receiver', '', array('style' => 'width: 98%')) ?>
            <?php echo CHtml::hiddenField('Message_receiver_id'); ?>

        </div>
    <br />
    <div class="row buttons" align="right">
        <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
        <div style="height:0px;overflow:hidden">
            <input type="file" multiple="multiple"  id="images" name="images[]" />
        </div>
        <button class="btn" type="button" onclick="chooseFile();">Add Images</button>

        <?php //echo CHtml::htmlButton('Add Images', array('class'=>'btn', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton('Post Question', array('class'=>'btn btn-info', 'type'=>'submit')); ?>


        <script>
            function chooseFile() {
                $("#images").click();
            }
        </script>
    </div>

<?php $this->endWidget(); ?>
    <?php $this->renderPartial('message.views.message.default._suggest'); ?>
</div><!-- form -->

