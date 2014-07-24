<h1><?php echo UserModule::t('Followers'); ?></h1>
<br />

<div id="content">
    <div class="row">
        <div class="span7">
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$data,
                    'summaryText'=>'',
                    'itemView'=>  '_people',   // refers to the partial view named '_post'
                ));
            ?>
        </div> <!-- span7 Left Pane -->

        <div class="span4 offset1">
            <div class="well">
                <b>Recommended Users to Follow</b><br><br>
                <?php
                    foreach($recommended as $i => $item): ?>
                        <div style="padding:3px;">
                           <div>
                                <?php $profile_picture = (!empty($item->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$item->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg'); ?>
                                <img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="<?php echo $profile_picture?>" alt="profile picture">
                           </div>
                           <div style="float:left;max-width:45%" class="question-action">
                                <a href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$item->id; ?>"><?php echo $item->profile->firstname. ' ' . $item->profile->lastname; ?></a>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                <?php endforeach; ?>

            </div>
        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->