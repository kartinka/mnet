<div class="view" style="margin-bottom: 15px">
    <div style="margin-left:10px; margin-right: 15px; float: left;">
        <?php echo CHtml::ajaxLink(
            'Unfollow', //$data->text,
            Yii::app()->createUrl("user/following/people/" . $data->id),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->id, //$myplaces[$i]['car_type'],
                    //$myplaces[$i]['car_code'],
                ),
                "success"=>'js:function(data){
                                                            $("#followP_"+data.id).text(data.text);
                                                            $("#followP_"+data.id).removeClass();
                                                            $("#followP_"+data.id).addClass(data.class);
                                                        }',
            ),
            array(
                'id' => 'followP_' .$data->id,
                'class' => 'btn btn-danger',
                'style' => 'font-weight: bolder'
            )
        );
        ?>
    </div>

    <?php if ($data->profile_picture != ''): ?>
        <div style="float:left">
            <img border="1" style="padding-right: 8px ;max-width:50px;max-height:50px;" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture?>" alt="profile picture" />
        </div>
    <?php endif; ?>

    <div class='boxbyphoto' style="float: left;">
        <div class='question-headline'>
            <a target="_blank" href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->id?>"><?php echo $data->profile->firstname. ' ' . $data->profile->lastname?></a>
        </div>
        <div class='question-nonboldaction'>
            <b><?php echo $data->profile->specialty?></b>
        </div>
        <?php if ($data->any_job): ?>
            <div>
                <font style="color:black;font-size:12px; font-weight: bold"><?php echo $data->any_job->location ?></font>
            </div>
        <?php endif; ?>
    </div>
    <div style="clear: both"></div>
</div>
<br>