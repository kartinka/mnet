<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->_id,
);

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Update Question', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete Question', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h1>View Question #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'question_text',
		'question_detail',
		'followers',
		'images',
		'answers',
		'question_author',
		'question_anonymous',
	),
)); ?>
