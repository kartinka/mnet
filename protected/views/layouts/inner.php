<?php
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <!-- custom CSS -->
    <?php Yii::app()->bootstrap->register(); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/styles.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/jquery-ui.css'); ?>

    <?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/functions.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/common.js'); ?>
    <?php Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="wrapper">
            <?php
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'brand'=>'<img src="'. Yii::app()->request->baseUrl .'/images/mednet_logo_35.png"/>',
                    'brandUrl'=> Yii::app()->request->baseUrl,
                    'fixed' => 'top',
                    'collapse'=>true, // requires bootstrap-responsive.css
                    'items'=>array(
                        !Yii::app()->user->isGuest? '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>': '',
                        array(
                            'class'=>'bootstrap.widgets.TbMenu',
                            'htmlOptions'=>array('class'=>'pull-right'),
                            'items'=>array(
                                array('label'=>'Ask Question', 'url'=>Yii::app()->baseUrl.'/question/create', 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'FAQ', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Home', 'url'=>Yii::app()->baseUrl.'/home/index', 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'My Account', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest,
                                    'items'=>array(
                                        array('label'=>'Mail', 'url'=>'#'),
                                        array('label'=>'Edit Profile', 'url'=>'#'),
                                        array('label'=>'Customize Feed', 'url'=>'#'),
                                        '---',
                                        array('label'=>'Logout', 'url'=> Yii::app()->baseUrl.'/user/logout'),
                                    )

                                ),
                            ),

                        ),
                    )
                ))
            ?>
<div id="container" class="container">
    <div class="container">
            <?php echo $content; ?>
    </div>
</div> <!-- container -->
</div> <!-- wrapper -->
</div>
<div class="push"></div>
</div>
<div class="footer"><hr>
    <div align="center">
        Copyright &copy; 2013 YOUR SITE <br/>
        All Rights Reserved.
    </div>
</div><!-- footer -->
</body>
</html>
