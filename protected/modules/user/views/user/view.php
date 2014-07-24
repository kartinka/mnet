<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
    UserModule::t("Profile")=>array('profile'),
    UserModule::t("Edit"),
);
$this->menu=array(
    ((UserModule::isAdmin())
        ?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
        :array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?><h1><?php echo UserModule::t('My profile'); ?></h1>
<br />
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
<?php endif; ?>

<div class="row">
                <div class="span8">
                        <div class="well p-minsize" style="min-height:100px;">

                            <?php
                                $profile_picture = (!empty($model->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$model->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg');
                                echo CHtml::image($profile_picture ,$profile->firstname . ' ' . $profile->lastname,
                                    array('style' => 'max-width:172px;max-height:200px; border: 1;', 'class' => 'p-profilepic')); ?>

                            <h1 class="p-namecard-name"><?php echo $profile->firstname . ' ' . $profile->lastname; echo ($profile->degrees)? ', ' . str_replace (';', ', ', $profile->degrees): ''; ?></h1>
                            <?php if (isset($model->current_job)): ?>
                                <div class="p-namecard-position">
                                    <font style='color:black;font-size:12px;'><?php echo $model->current_job->name; ?></font><br />
                                    <?php echo $model->current_job->location; ?>
                                    <?php if ($owner):?>
                                        <a class="edit" href="<?php echo Yii::app()->baseUrl . '/job/edit/id/' . $model->current_job->id; ?>">Edit</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                                <h4 class="p-namecard-specialty">Radiation Oncology</h4>
                                    <?php $subs = explode (';', $profile->subspecialties);
                                        foreach ($subs as $sub)
                                            echo "<span class='label label-default' style='margin-bottom:3px;'>" . $sub . "</span>&nbsp;";
                                    ?>
                                </br></br>
                                <div>
                                    <?php
                                        if (trim($profile->interests) !="")
                                            echo $profile->interests;
                                    ?>
                                </div>
                                <?php if ($owner):?>
                                    <a class="edit" href="/mednet/index.php/user/profile/edit">Edit</a><br/><br/>
                                <?php endif; ?>
                            <div style="clear:both"></div>

                        </div>

                    <!-- TABS -->
                    <div id="yw0"><div class="tab-content"></div></div>
                    <div id="yw0">
                        <ul id="yw1" class="nav nav-tabs" style="margin-bottom: 0;">
                            <!-- <li class="active"><a data-toggle="tab" href="#yw0_tab_1">Training and Education</a></li> -->
                            <li class="active"><a data-toggle="tab" href="#yw0_tab_3">Work History</a></li>
                        </ul>

                            <div id="yw0_tab_3" class="tab-pane tab-border">

                                <?php //$this->renderPartial('//job/_form', array('model'=>new Job, 'user_id'=> Yii::app()->user->id )); ?>

                                <?php
                                $this->widget('zii.widgets.CListView', array(
                                    'dataProvider'=>$jobs,
                                    'summaryText'=>'',
                                    'viewData'=>array('owner'=>$owner),
                                    'itemView'=> '//job/_view'
                                ));
                                ?>

                                <?php if ($owner):?>
                                    <?php echo CHtml::ajaxLink('Add a position',
                                        Yii::app()->createUrl('job/create'),
                                        array(
                                            'type'=>'post',
                                            'dataType'=> 'html',
                                            'success'=> 'function(html){jQuery("#job-modal-create").html(html).modal(); return false;}',//'function(html){jQuery("#qq").empty(); jQuery("#qq").html(html); $("#job-modal").modal(); return;}',
                                            array(
                                              'data-toggle'=>'modal',
                                                'data-target'=>'#job-modal-create',
                                            ),
                                        ),
                                        array(
                                            'class' => 'btn btn-info'
                                        )
                                    );?>
                                <?php endif; ?>
                            </div>

                        </div>
                </div>


                <?php if ($owner): ?>
                    <div class="span4">
                        <div class="list-group">
                            <a href="<?php echo Yii::app()->baseUrl?>/user/user/view/id/me" class="list-group-item active"><i class="icon-chevron-left"></i> My profile </a>
                            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/edit" class="list-group-item">Edit Account details</a>
                            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item">Change Password</a>
                            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item">Update Profile Picture</a>
                            <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item">Email Preferences</a>
                            <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item">Feed Settings</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="span4">
                        <div class="well" >
                            <div>
                                <div style="margin-bottom:10px; text-align: center">
                                    <?php echo CHtml::link('<i class="icon-envelope"></i> ' . 'Send Message',  Yii::app()->baseUrl . "/message/compose/" . $model->id, array('class' => 'btn')); ?>
                                    <?php echo CHtml::ajaxLink(
                                        $follow_attributes['text'],
                                        Yii::app()->createUrl("user/following/people/" . $model->id),
                                        array(
                                            "type"=>"POST",
                                            "dataType"=>"json",
                                            "data"=>array(
                                                "id"=> $model->id, //$myplaces[$i]['car_type'],
                                                 //$myplaces[$i]['car_code'],
                                            ),
                                            "success"=>'js:function(data){
                                                            $("#followP_"+data.id).text(data.text);
                                                            $("#followP_"+data.id).removeClass();
                                                            $("#followP_"+data.id).addClass(data.class);
                                                        }',
                                        ),
                                        array(
                                            'id' => 'followP_' .$model->id,
                                            'class' => $follow_attributes['class'],//'btn btn-info',
                                            'style' => 'font-weight: bolder'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Related Questions -->
                        <?php if (!$owner): ?>
                            <div class="well">
                                <div class="boxhilight">
                                    <ul class="nav nav-list">
                                        <b>Recent Activity</b><br>
                                        <?php
                                            $data = $recent_activity->getData();
                                            foreach($data as $i => $item)
                                                Yii::app()->controller->renderPartial('//question/_recent_activity',
                                                    array('index' => $i, 'data' => $item, 'widget' => $this));
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div> <!-- span4 Right Pane-->
                <?php endif; ?>
</div> <!-- row -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'job-modal-create')); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'job-modal-edit')); ?>
<?php $this->endWidget(); ?>

