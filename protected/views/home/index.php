<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('questionCreated')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('questionCreated'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('questionAnswered')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('questionAnswered'); ?>
    </div>
<?php endif; ?>

<div id="content">
  <div class="row">
      <div class="span7">
          <ul class="nav nav-tabs">
              <li class="<?php print ($answered)? 'active': '';?>"><a href="<?php echo Yii::app()->baseUrl; ?>/home/index">Most Recent</a></li>
              <li class="<?php print ($answered)? '': 'active'?>"><a href="<?php echo Yii::app()->baseUrl; ?>/home/open">Unanswered Questions</a></li>
              <li class="hidden-phone" style="float:right;width:100px;"><a href="<?php echo Yii::app()->baseUrl; ?>/user/following/topicfeed" data-toggle="tooltip" data-placement="top" title="Customize your feed"><i class="icon-cog"><div style="padding-left:20px;font-size:10px;">Customize</div></i></a></li>
          </ul>

          <?php
              $this->widget('zii.widgets.CListView', array(
                  'dataProvider'=>$questions,
                  'summaryText'=>'',
                  'itemView'=>($answered)?'_answered': '_unanswered',   // refers to the partial view named '_post'
              ));
          ?>

      </div> <!-- span7 Left Pane -->

      <?php Yii::app()->controller->renderPartial('_right_pane',
        array('user'=>$user, 'profile'=>$profile, 'questions' => $questions, 'discussions' => $discussions, 'invitees' => $invitees, 'topics' => $topics, 'followers' => $followers)); ?>

  </div> <!-- row -->
</div> <!-- content -->
