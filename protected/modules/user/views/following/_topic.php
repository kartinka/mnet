<div class="view" style="margin-bottom: 15px">
    <div style="margin-left:10px; margin-right: 15px; float: left;">
        <?php echo CHtml::ajaxLink(
            'Unfollow',
            Yii::app()->createUrl("user/following/topic/" . $data->id),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->id, //$myplaces[$i]['car_type'],
                    //$myplaces[$i]['car_code'],
                ),
                "success"=>'js:function(data){
                                                            $("#followT_"+data.id).text(data.text);
                                                            $("#followT_"+data.id).removeClass();
                                                            $("#followT_"+data.id).addClass(data.class);
                                                        }',
            ),
            array(
                'id' => 'followT_' .$data->id,
                'class' => 'btn btn-danger',
                'style' => 'font-weight: bolder'
            )
        );
        ?>
    </div>
    <div class='questiontopic'>
        <a href="<?php echo Yii::app()->baseUrl.'/topic/view/id/'.$data->id?>">
            <?php echo $data->text;?>
        </a>
        <div class="question-nonboldaction">
            <?php echo $data->questionsCount . ' ';  echo ($data->questionsCount == 1)? 'Question': 'Questions'; ?>
        </div>
    </div>

</div>
<br>