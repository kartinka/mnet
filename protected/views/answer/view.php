<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div id="content">
    <div class="row">
        <div class="span7">
            <div style="color: #696e6f;"> Topics: <?php $topics = explode (';', $question->topics); echo $topics[0];?> &middot; <?php echo $topics[1];?> </div>
            <div> <?php  echo $question->text ?></div>
            <div> <?php echo $question->detail ?></div>
            <div> Question created: <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$question->create_at); ?></div>
            <br /><br />
            <div class="well">
                <?php foreach ($answers as $answer): $answer = (object)$answer;?>
                    <div class="namecard">
                        <div style="float:left">
                            <img border="1" style="padding: 8px 0px 8px 15px;max-width:60px;max-height:60px;" align="ABSMIDDLE" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$answer->profile_picture?>" alt="profile picture">
                        </div>
                        <div class="p-namecard-position" style="padding-top:8px;">
                            <span>Added <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$answer->create_at);?> </span>
                            <span> <?php echo $answer->answer ?> </span>
                            <a href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$answer->answerer?>"><?php echo $answer->firstname. ' ' . $answer->lastname?></a><br>
                            <div class="p-namecard-position" style="color:#696e6f;">
                                <font style="color:black;font-size:12px;"><?php echo $answer->location?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div>
                <?php $this->renderPartial('_form'); ?>
            </div>
        </div> <!-- span7 Left Pane-->
        <div class="span4 offset1">
            <div class="well" >

            </div>

        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->