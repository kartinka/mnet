<!-- HIDDEN COMMENT FORM-->
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'comment-form-' . $a_id,
        'action'=> Yii::app()->baseUrl.'/answer/comment',
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'focus'=>array($model,'text'),
        'htmlOptions' => array(
            'style' => 'display: none'
        )
    )); ?>

    <?php echo CHtml::hiddenField('answer_id', $a_id); ?>
    <?php echo CHtml::hiddenField('question_id', $q_id); ?>
    <?php echo CHtml::hiddenField('author_id', $author_id); ?>

    <div class="control-group">
        <div class="controls">
            <?php echo $form->textArea($model,'text',array('rows'=>3, 'cols'=>30, 'style'=>'width: 98%')); ?>
        </div>
    </div>

    <div class="row buttons" align="right">
        <?php echo CHtml::htmlButton('Post comment', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
    </div>

    <?php $this->endWidget(); ?>
