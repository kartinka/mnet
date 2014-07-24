<div class="span4 offset1 hidden-phone">
    <div class="well" style="padding: 8px 0;">
        <div style="float:left">
            <?php $profile_picture = (!empty($user->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$user->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg');?>
            <img border="1" style="padding: 8px 0px 8px 15px;max-width:100px;max-height:100px;" align="ABSMIDDLE" src="<?php echo $profile_picture?>" alt="profile picture">
        </div>
        <div class="namecard">
            <div style="float:left;padding-top:8px;">
                <a href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.Yii::app()->user->id?>"><?php echo $profile->firstname. ' ' . $profile->lastname?></a><br>
                <?php if (isset($user->current_job)): ?>
                    <div class="p-namecard-position" style="color:#696e6f;">
                        <font style="color:black;font-size:12px;"><?php echo $user->current_job->name;?></font><br><?php echo $user->current_job->location;?>
                    </div>
                <? endif; ?>
            </div>
        </div>
        <div style="clear:both"></div>
        <b>
            <ul class="nav nav-list">
                <li><a href="<?php echo Yii::app()->baseUrl. '/user/user/view/id/me'; ?>"><i class="icon-cog"></i> Settings</a></li>
                <li><a href="<?php echo Yii::app()->baseUrl. '/message/inbox'; ?>"><i class="icon-envelope"></i> Mail </a></li>
                <li><a href="<?php echo Yii::app()->baseUrl. '/user/stats/all'; ?>"><i class="icon-signal"></i> Stats</a></li>

                <!--Followers -->
                <li><a href="<?php echo Yii::app()->baseUrl. '/user/following/followers'; ?>"><i class="icon-user"></i>Followers (<?php echo $followers;?>)</a></li>
            </ul>
        </b></div><b> <!-- /well -->
    </b>
    <!-- Hot Topics -->

    <div class="well">
        <div class="boxhilight"><ul class="nav nav-list">
                <div style="margin-bottom:10px;"><b>Most Active Topics</b></div>
                <?php if ($topics && !empty($topics)): ?>
                    <?php foreach ($topics as $key => $value): ?>
                        <li>
                            <a href="<?php echo Yii::app()->baseUrl . '/topic/view/id/' . $value->topics ?>"> <?php echo $value->topic . ' (' . $value->answers_number . ')'?> </a>
                        </li>
                    <?php endforeach; ?>
                <?php else:?>
                    No updates within last 5 days.
                <?php endif; ?>
        </div>

        <div style="margin-top:10px;"><b>Browse all</b>
            <a class="last-line-action" href="<?php echo Yii::app()->baseUrl?>/topic/all">Topics</a>,
            <a class="last-line-action" href="<?php echo Yii::app()->baseUrl?>/user/user/all">People</a>,
            <a class="last-line-action" href="<?php echo Yii::app()->baseUrl?>/question/all">Questions</a>
        </div>
    </div>

    <!-- Invitation Module -->

    <div class="well">
        <b>People You May Know</b><br><br>
        <!--You have <font color=red><b>(99)</b></font> invites remaining.</br></br> -->
        <?php
        foreach($invitees as $i => $item)
            Yii::app()->controller->renderPartial('_invitee',
                array('index' => $i, 'data' => $item, 'widget' => $this));
        ?>

        <div style="margin-top:10px;">
            <a class="last-line-action" href="<?php echo Yii::app()->baseUrl . '/user/invite/suggest'; ?>">See More</a>
        </div>
    </div>


    <!--Followers -->
    <!-- Recommedned Questions -->

    <div class="well">
        <div class="boxhilight"><ul class="nav nav-list">
                <b>Most Active Discussions</b><br>
                <?php
                    $data = $discussions->getData();
                    foreach($data as $i => $item)
                        Yii::app()->controller->renderPartial('_discussion',
                            array('index' => $i, 'data' => $item, 'widget' => $this));
                ?>
        </div>

    </div> <!-- span4 Right Pane-->