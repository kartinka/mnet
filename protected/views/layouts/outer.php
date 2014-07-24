<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <!-- custom CSS -->
    <?php Yii::app()->bootstrap->register(); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/styles.css'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title'=>'Operations',
));
$this->widget('zii.widgets.CMenu',
    array(
        'items'=>$this->menu,
        'htmlOptions'=>array('class'=>'operations')
    )
);
$this->endWidget();
?>

<body>
<div id="wrap">
    <div class="container clear-top" id="main">

        <?php echo $content; ?>

    </div>

    </div><!-- container -->
</div>

<div class="foot">
    <hr>
    <span style="padding-left:12px;">Copyright &copy; 2014 <?php echo Yii::app()->name;?></span>
    <a style="padding-right:12px;padding-left:12px;color:#999;" href="<?php echo Yii::app()->request->baseUrl;?>/site/tos">Terms of Use</a><a style="padding-right:12px;color:#999;" href="<?php echo Yii::app()->request->baseUrl;?>/site/privacy">Privacy Policy</a>
</div><!-- footer -->
</body>
</html>
