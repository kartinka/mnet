<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->_id), array('view', 'id'=>$data->_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_text')); ?>:</b>
	<?php echo CHtml::encode($data->question_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_detail')); ?>:</b>
	<?php echo CHtml::encode($data->question_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('followers')); ?>:</b>
	<?php echo CHtml::encode($data->followers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('images')); ?>:</b>
	<?php echo CHtml::encode($data->images); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answers')); ?>:</b>
	<?php echo CHtml::encode($data->answers); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_author')); ?>:</b>
	<?php echo CHtml::encode($data->question_author); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('question_anonymous')); ?>:</b>
	<?php echo CHtml::encode($data->question_anonymous); ?>
	<br />

	*/ ?>

</div>