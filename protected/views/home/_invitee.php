<div style="padding:3px;">

    <div style="margin-left:10px; margin-right: 15px; float: left;">
        <?php echo CHtml::ajaxLink(
            $data->text,//'Invite',
            Yii::app()->createUrl("user/invite/people/" . $data->id),
            array(
                "type"=>"POST",
                "dataType"=>"json",
                "data"=>array(
                    "id"=> $data->id, //$myplaces[$i]['car_type'],
                    //$myplaces[$i]['car_code'],
                ),
                "success"=>'js:function(data){ if (data) {
                                                $("#invite_"+data.id).text(data.text);
                                                $("#invite_"+data.id).removeClass();
                                                $("#invite_"+data.id).addClass(data.class);
                                               }
                                              }',
            ),
            array(
                'id' => 'invite_' .$data->id,
                'class' => $data->class,//'btn btn-success',
                'style' => 'margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px'
            )
        );
        ?>
       </div>
        <div>
            <?php $profile_picture = (!empty($data->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg'); ?>
            <img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="<?php echo $profile_picture?>" alt="profile picture">
        </div>
        <div style="float:left;max-width:45%" class="question-action">
            <a href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->id; ?>"><?php echo $data->profile->firstname. ' ' . $data->profile->lastname; ?></a>
        </div>
    <div style="clear:both"></div>
</div>
