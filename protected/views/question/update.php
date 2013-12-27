<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->_id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'View Question', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h1>Update Question <?php echo $model->_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>