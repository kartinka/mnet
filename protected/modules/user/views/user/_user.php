    <div style="float:left">
        <?php $profile_picture = (!empty($data->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg');?>
        <img border="1" style="padding: 8px 0px 8px 15px;max-width:100px;max-height:100px;" align="ABSMIDDLE" src="<?php echo $profile_picture?>" alt="profile picture">
    </div>
    <div class="namecard">
        <div style="float:left;padding-top:8px;">
            <a href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'. $data->id?>"><?php echo $data->profile->firstname. ' ' . $data->profile->lastname?></a><br>
            <?php if (isset($data->current_job)): ?>
                <div class="p-namecard-position" style="color:#696e6f;">
                    <font style="color:black;font-size:12px;"><?php echo $data->current_job->name;?></font>
                    <br>
                    <?php echo $data->current_job->location;?>
                </div>
            <? endif; ?>
        </div>
    </div>
    <div style="clear:both"></div>
