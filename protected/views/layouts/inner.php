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

<body>

<div class="wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner"><div class="container">
            <a href="/mednet" class="brand"><img src="/mednet/images/mednet_logo_35.png"></a>
        </div>
     </div>
</div>
            <div id="container" class="container">
                <?php echo $content; ?>
            </div> <!-- container -->
</div> <!-- wrapper -->
</div>
<div class="push"></div>
</div>
<div class="footer"><hr>
    <div align="center">
        Copyright &copy; 2013 theMednet <br/>
        All Rights Reserved.
    </div>
</div><!-- footer -->
</body>
</html>
