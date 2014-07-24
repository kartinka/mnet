<h1><?php echo UserModule::t('My statistics'); ?></h1>
<br />

<div id="content">
    <div class="row">
                <div class="span8">
                    <ul class="nav nav-tabs">
                        <li class="<?php print ($title == 'week')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/stats/week">Last Week</a></li>
                        <li class="<?php print ($title == 'month')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/stats/month">Last Month</a></li>
                        <li class="<?php print ($title == 'all')? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/user/stats/all">All Time</a></li>
                    </ul>
                        <div class="well p-minsize" style="min-height:100px;">

                            <?php
                                $profile_picture = (!empty($model->profile_picture)? Yii::app()->baseUrl.'/images/profile/'.$model->profile_picture: Yii::app()->baseUrl.'/images/profile/no-photo.jpg');
                                echo CHtml::image($profile_picture ,$model->profile->firstname . ' ' . $model->profile->lastname,
                                    array('style' => 'max-width:172px;max-height:200px; border: 1;', 'class' => 'p-profilepic')); ?>

                            <h1 class="p-namecard-name"><?php echo $model->profile->firstname . ' ' . $model->profile->lastname . ', ' . str_replace (';', ', ', $model->profile->degrees); ?></h1>
                            <?php if (isset($model->current_job)): ?>
                                <div class="question-headline">
                                    <font style='color:black;font-size:12px;'><?php echo $model->current_job->name; ?></font><br />
                                    <?php echo $model->current_job->location; ?>
                                </div>
                            <?php endif; ?>
                                <h2 class="p-namecard-name">Summary</h2>
                                <br />
                                <div class="question-action">
                                    Answers Viewed: <span class="totals"> <?php echo $stats_totals['answers']; ?> </span> <br />
                                    Total Views: <span class="totals"> <?php echo $stats_totals['views']; ?> </span> <br />
                                    People Reached: <span class="totals"> <?php  echo $stats_totals['people'];  ?> </span> <br />
                                    Institutions Reached: <span class="totals"> <?php  echo $stats_totals['institutions'];  ?> </span> <br />
                                </div>
                            <div style="clear:both"></div>

                        </div> <!-- well -->

                        <?php //var_dump($jobs);

                                $this->widget('zii.widgets.CListView', array(
                                    'dataProvider'=>$stats_answers,
                                    'summaryText'=>'',
                                    'itemView'=> '_stat'
                                ));

                        ?>

                    </div>

                    <div class="span4">
                        <div class="list-group">
                            <a href="<?php echo Yii::app()->baseUrl?>/user/user/stats" class="list-group-item active"><i class="icon-chevron-left"></i> My answers </a>
                        </div>
                        <div class="well">
                            <b>People You May Know</b><br><br>
                            <!--You have <font color=red><b>(99)</b></font> invites remaining.</br></br> -->
                            <?php
                            foreach($invitees as $i => $item)
                                Yii::app()->controller->renderPartial('//home/_invitee',
                                    array('index' => $i, 'data' => $item, 'widget' => $this));
                            ?>

                            <div style="margin-top:10px;">
                                <a class="last-line-action" href="<?php echo Yii::app()->baseUrl . '/user/invite'; ?>">See More</a>
                            </div>
                        </div>
                    </div>
    </div> <!-- row -->
</div> <!-- content -->
