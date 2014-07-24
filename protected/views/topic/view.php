<?php

$this->pageTitle=Yii::app()->name;
?>

<div id="content">
    <div class="row">
        <div class="span7">
            <div class="well" >
                <div class="boxhilight">
                        <h2><?php echo $topic->text;?></h2>
                </div>
            </div>

            <?php
                if ($questions_answered)
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$questions_answered,
                        'summaryText'=>'',
                        'itemView'=> '_answered',   // refers to the partial view named '_post'
                    ));
            ?>

            <?php
                if ($questions_unanswered)
                    $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$questions_unanswered,
                    'summaryText'=>'',
                    'itemView'=> '_unanswered',   // refers to the partial view named '_post'
                ));
            ?>
            <?php if (!$questions_answered and !$questions_unanswered): ?>
                No questions related to this topic.
            <?php endif; ?>
        </div> <!-- span7 Left Pane -->

        <div class="span4 offset1">
            <div class="well" >
                <div>
                    <div align="center">
                        <?php echo CHtml::ajaxLink(
                            $follow_attributes['text'],
                            Yii::app()->createUrl("user/following/topic/" . $topic->id),
                            array(
                                "type"=>"POST",
                                "dataType"=>"json",
                                "data"=>array(
                                    "id"=> $topic->id, //$myplaces[$i]['car_type'],
                                    //$myplaces[$i]['car_code'],
                                ),
                                "success"=>'js:function(data){
                                                            $("#followT_"+data.id).text(data.text);
                                                            $("#followT_"+data.id).removeClass();
                                                            $("#followT_"+data.id).addClass(data.class);
                                                        }',
                            ),
                            array(
                                'id' => 'followT_' .$topic->id,
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
                        <b>Related Topics</b><br>
                        <?php
                        /*
                        $data = $related_questions->getData();
                        foreach($data as $i => $item)
                            Yii::app()->controller->renderPartial('_related_question',
                                array('index' => $i, 'data' => $item, 'widget' => $this));
                        */
                        ?>
                    </ul>
                </div>
            </div>

        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->