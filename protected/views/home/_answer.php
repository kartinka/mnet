<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div class="row">

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detail')); ?>:</b>
	<?php echo CHtml::encode($data->detail); ?>
	<br />

    <?php $this->renderPartial('_question', array('data'=>$question)); ?>

</div>