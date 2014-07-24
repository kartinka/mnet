<div class="view" style="margin-bottom: 15px">
    <div style="margin-left:10px; margin-right: 15px; float: left;">
        <?php echo CHtml::ajaxLink(
            'Unfollow',
            Yii::app()->createUrl("user/following/question/" . $data->id),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->id,
                ),
                "success"=>'js:function(data){
                                                            $("#followQ_"+data.id).text(data.text);
                                                            $("#followQ_"+data.id).removeClass();
                                                            $("#followQ_"+data.id).addClass(data.class);
                                                        }',
            ),
            array(
                'id' => 'followQ_' .$data->id,
                'class' => 'btn btn-danger',
                'style' => 'font-weight: bolder'
            )
        );
        ?>
    </div>
    <div class='questiontopic' style="margin-left: 115px">
        <a href="<?php echo Yii::app()->baseUrl.'/question/view/id/'.$data->id?>">
            <?php echo $data->text;?>
        </a>
        <div class="question-nonboldaction">
            <?php echo $data->answersCount . ' ';  echo ($data->answersCount == 1)? 'Answer': 'Answers'; echo ' available'; ?>
        </div>
    </div>

</div>
<br>