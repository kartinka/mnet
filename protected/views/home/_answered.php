<div class="view">

    <div class="question-headline">
        <?php echo CHtml::link($data->question, Yii::app()->baseUrl.'/question/view/id/'.$data->q_id); ?>
    </div>
    <div>
        <?php echo CHtml::encode($data->detail); ?>
    </div>


    <div class="post-infoblock">
        <?php if ($data->profile_picture != ''): ?>

            <div style="float:left">
                    <img border="1" style="padding-right: 8px ;max-width:50px;max-height:50px;" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture?>" alt="profile picture" />
            </div>
        <?php endif; ?>

        <div class='boxbyphoto'>
            <div class='question-nonboldaction'>
                <b>New answer</b>
                <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$data->create_at);?>
            </div>
            <div class='question-detail'>
                <?php echo $data->answer ?>...
            </div>
            <div class='question-nonboldaction'>
                <b><a target="_blank" href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->answerer?>"><?php echo $data->firstname. ' ' . $data->lastname?></a></b>, <?php echo $data->location?>
            </div>

        </div>
    </div>
    <div style="clear:both"></div>
    <div class="last-line-action">

        <!-- <a href="javascript:void(0)" class="t" onclick="follow('<?php echo $data->q_id?>','Q','link','long');" id="followQ<?php echo $data->q_id?>" >Follow Question</a> -->
        <?php echo CHtml::ajaxLink(
            $data->q_text,
            Yii::app()->createUrl("user/following/question/" . $data->q_id),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->q_id, //$myplaces[$i]['car_type'],
                    //$myplaces[$i]['car_code'],
                ),
                "success"=>'js:function(data){
                     $("#followQ_"+data.id).text(data.text);

                    }',
            ),
            array(
                'id' => 'followQ_' .$data->q_id,
                //'class' => $follow_attributes['class'],//'btn btn-info',
                'style' => 'font-weight: bolder'
            )
        );
        ?>

        &bull;
        <?php echo CHtml::ajaxLink(
            $data->p_text . ' User',
            Yii::app()->createUrl("user/following/people/" . $data->inquirer),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->inquirer, //$myplaces[$i]['car_type'],
                    //$myplaces[$i]['car_code'],
                ),
                "success"=>'js:function(data){
                                                            $("#followP_"+data.id).text(data.text);
                                                        }',
            ),
            array(
                'id' => 'followP_' .$data->inquirer,
                //'class' => $follow_attributes['class'],//'btn btn-info',
                'style' => 'font-weight: bolder'
            )
        );
        ?>
        &bull;&nbsp;
        <?php
            $answers = ($data->answers_number>1)?' Answers':' Answer';
            echo CHtml::link($data->answers_number . $answers . ' available', Yii::app()->baseUrl.'/question/view/id/'.$data->q_id);
        ?>
    </div>
</div>
<br />
