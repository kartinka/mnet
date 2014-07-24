<?php

$this->pageTitle=Yii::app()->name;
?>
<h1> Search Results</h1>
<br />
<div id="content">
  <div class="row">
      <div class="span7">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
              <li><a href="#people" data-toggle="tab">People</a></li>
          </ul>

<section class="tab-content">
    <article class="tab-pane active" id="questions">
        <div class="well" >

            <?php
            if ($questions)
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$questions,
                    'summaryText'=>'',
                    'itemView'=> '_search_answered',   // refers to the partial view named '_post'
                ));
            ?>
        </div>
     </article>
    <article class="tab-pane" id="people">
        <?php
            if ($users)
                $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$users,
                'summaryText'=>'',
                'itemView'=> 'user.views.user._user',   // refers to the partial view named '_post'
                ));
            else
                echo "No registered users found."
        ?>
    </article>
</section>
      </div> <!-- span7 Left Pane -->

      <?php //Yii::app()->controller->renderPartial('_right_pane',
        //array('user'=>$user, 'profile'=>$profile, 'questions' => $questions, 'discussions' => $discussions, 'invitees' => $invitees, 'topics' => $topics, 'followers' => $followers)); ?>

  </div> <!-- row -->
</div> <!-- content -->
