<?php
/* @var $this QuestionController */
/* @var $data Question */
?>

<div id="content">
    <div class="row">
        <div class="span7">
            <?php if ($question->topics) :?>
                <div class='questiontopic'> Topics:
                        <a href="<?php echo Yii::app()->baseUrl.'/topic/view/id/'.$question->topics?>">

                        <?php echo $question->topic->text; //$topics = explode (';', $question->topics); echo $topics[0];?> </a>
                        &middot;
                        <a href="<?php echo Yii::app()->baseUrl.'/topic/view/all'?>">Radiation Oncology <?php //echo $topics[1];?> </a>
                </div>
            <?php endif; ?>
            <div class="qp-questionheadline"> <?php  echo $question->text ?></div>
            <br />
            <?php if ($question->detail != ''): ?>
                <div> <?php echo $question->detail ?></div>
                <br />
            <?php endif; ?>
            <?php if ($question->images): ?>
                <?php $images = explode(';',$question->images);?>
                <?php
                    foreach ($images as $image) {
                        if ($image !="") {
                            $current_picture = Yii::app()->baseUrl.'/images/questions/'. $question->id . '/' . $image;
                            echo CHtml::image($current_picture,'Profile Picture',
                                array('style' => 'max-width:172px;max-height:200px; padding: 8px 0px 8px 15px;'));
                        }
                        //echo &nbsp;
                    }
                ?>

            <?php endif; ?>

            <div class='p-pubitemdetail'> <b>Question created: <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$question->create_at); ?></b></div>
            <br /><br />

                <?php if (count((array)$answers) > 0):?>
                        <?php foreach ($answers as $answer): $answer = (object)$answer;?>
                            <?php echo CHtml::hiddenField('answer_' . $answer->a_id); ?>
                            <div class="well">
                                <?php if ($answer->profile_picture !=''):?>
                                    <div style="float:left; margin-right: 5px">
                                        <img border="1" style="padding: 8px 0px 8px 15px;max-width:60px;max-height:60px;" align="ABSMIDDLE" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$answer->profile_picture?>" alt="profile picture"><?php ?>
                                    </div>
                                <?php endif; ?>
                                <div style="padding-top:8px;" class="question-nonboldaction">
                                    <?php echo '<b>' . CHtml::link($answer->firstname. ' ' . $answer->lastname, Yii::app()->baseUrl.'/user/user/view/id/'.$answer->answerer, array('style' => 'text-decoration:underline')) . ', ' . $answer->location . '</b>'; ?>
                                    <br />
                                    <div class='p-pubitemdetail'><b>Added <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$answer->create_at);?></b> </div>
                                    <div style='clear:both;'></div>
                                    <div> <?php echo $answer->answer ?> </div>
                                </div>

                                <?php echo CHtml::ajaxLink(
                                    '<i class="icon-thumbs-up"></i> ' . '<b>Helpful</b>',
                                    Yii::app()->createUrl("/answer/helpful"),
                                    array(
                                        "type"=>"POST",
                                        "dataType"=>"json",
                                        "data"=>array(
                                            "id"=> $answer->a_id,
                                            "answerer_id"=>$answer->answerer,
                                            "question_id"=>$question->id
                                        ),
                                        "success"=>'js:function(data){
                                            if (data) {
                                                $("#helpful_"+data.id).text("Marked as Helpful");
                                                $("#helpful_"+data.id).addClass(data.class);
                                            }
                                        }',
                                    ),
                                    array(
                                        'id' => 'helpful_' .$answer->a_id,
                                        'class' => 'btn offset5',
                                    )
                                );
                                ?>

                                <?php //echo CHtml::htmlButton('<i class="icon-thumbs-up"></i> ' . '<b>Helpful</b>', array('class'=>'btn offset5')); ?>
                                <div class="last-line-action">Share with:
                                    <?php foreach ($share as $s): ?>
                                                <?php echo CHtml::ajaxLink(
                                                    $s->profile->firstname . ' '.$s->profile->lastname,
                                                    Yii::app()->createUrl("answer/share/"),
                                                    array(
                                                        "type"=>"POST",
                                                        "dataType"=>"json",
                                                        "data"=>array(
                                                            "id"=> $s->id,
                                                            "answer_id"=> $answer->a_id,
                                                            "question_id"=>$question->id
                                                        ),
                                                        "success"=>'js:function(data){
                                                             $("#shareP_"+data.id+"_"+data.answer_id).text(data.text);
                                                             $("#shareP_"+data.id+"_"+data.answer_id).css("color", data.color);
                                                             $("#shareP_"+data.id+"_"+data.answer_id).removeAttr("href");
                                                            }',
                                                    ),
                                                    array(
                                                        'id' => 'shareP_' .$s->id. '_' . $answer->a_id,
                                                        //'class' => $follow_attributes['class'],//'btn btn-info',
                                                        'style' => 'font-weight: bolder'
                                                    )
                                                );
                                                ?>

                                    <?php endforeach;?>
                                   <!-- <a id="edit_job" class="edit" data-id="<?php echo $answer->a_id;?>" data-toggle="modal" data-target='#share-modal' href="<?php echo Yii::app()->baseUrl . '/job/edit/id/' . $answer->a_id; ?>">Edit</a> -->
                                    <?php /* echo CHtml::link('Others',
                                        '#',//sYii::app()->createUrl('answer/shareothers'),
                                            array(
                                                'data-toggle'=>'modal',
                                                'data-target'=>'#share-modal',
                                        )); */?>
                                </div>
                                <div class="last-line-action">
                                    <div id="comments_<?php echo $answer->a_id;?>" style="cursor: pointer" > Comments: </div>
                                </div>
                                <?php if (!empty($answer->comments)) : ?>
                                    <div class="p-pubitemdetail">
                                        <ul>
                                            <?php foreach ($answer->comments as $comment): ?>
                                                <li>
                                                <div>
                                                   <b> <?php echo $comment->text; ?> </b>
                                                   Added: <?php echo $comment->create_at; ?>
                                                </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                    <div class="p-pubitemdetail">
                                        <b> No comments yet. </b>
                                    </div>
                                <?php endif; ?>
                                <div class="last-line-action">
                                    <div id="add_comment_<?php echo $answer->a_id;?>" style="cursor: pointer" onclick="javascript: showCommentForm(this);"> Add comment </div>
                                </div>

                                <?php $this->renderPartial('/answer/_comment_form', array('model'=>$add_comment, 'a_id' => $answer->a_id, 'q_id' => $question->id, 'author_id'=> Yii::app()->user->id)); ?>

                            </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            <?php if(Yii::app()->user->hasFlash('answerFailed')): ?>
                <div class="flash-error">
                    <?php echo Yii::app()->user->getFlash('answerFailed'); ?>
                </div>
            <?php endif; ?>

            <div>
                <?php $this->renderPartial('/answer/_form', array('model'=>$add_answer, 'q_id' => $question->id)); ?>
            </div>
        </div> <!-- span7 Left Pane-->
        <div class="span4 offset1">
            <div class="well" >
                <div>
                    <div style="margin-bottom:10px; text-align: center">
                        <b>This question has been viewed <?php echo $question->viewed; echo ($question->viewed > 1)? ' times': ' time'; ?></b>
                    </div>
                    <div align="center">
                        <?php echo CHtml::ajaxLink(
                            $follow_attributes['text'],
                            Yii::app()->createUrl("user/following/question/" . $question->id),
                            array(
                                "type"=>"POST",
                                "dataType"=>"json",
                                "data"=>array(
                                    "id"=> $question->id, //$myplaces[$i]['car_type'],
                                    //$myplaces[$i]['car_code'],
                                ),
                                "success"=>'js:function(data){
                                                            $("#followQ_"+data.id).text(data.text);
                                                            $("#followQ_"+data.id).removeClass();
                                                            $("#followQ_"+data.id).addClass(data.class);
                                                        }',
                            ),
                            array(
                                'id' => 'followQ_' .$question->id,
                                'class' => $follow_attributes['class'],//'btn btn-info',
                                'style' => 'font-weight: bolder'
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>

            <!-- Related Questions -->

            <div class="well">
                <div class="boxhilight">
                    <ul class="nav nav-list">
                        <b>Related Questions</b><br>
                        <?php
                            $data = $related_questions->getData();
                            foreach($data as $i => $item)
                                Yii::app()->controller->renderPartial('_related_question',
                                    array('index' => $i, 'data' => $item, 'widget' => $this));
                        ?>
                    </ul>
                </div>
            </div>

            <div style="font-style: italic">
                The content of theMednet is for general knowledge sharing and dialogue. Clinicians should base their decision-making on independent medical judgment in the context of individual clinical circumstances of a specific patient\'s care oк treatment. In no event shall theMednet or it's members be liable for damages of any kind arising out of or in connection with the use of theMednet content.
            </div>

        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->
<?php //$this->renderPartial('_share_form', array('model'=>$share)); ?>