<?php

$this->pageTitle=Yii::app()->name;
?>
<div id="content">
  <div class="row">
      <div class="span7">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#questions" data-toggle="tab">Most Recent</a></li>
          </ul>

        <section class="tab-content">
            <article class="tab-pane active" id="questions">
                <div class="well" >

                    <?php
                    if ($questions)
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$questions,
                            'summaryText'=>'',
                            'itemView'=> '_answered_unauthorized',   // refers to the partial view named '_post'
                        ));
                    ?>
                </div>
             </article>
        </section>
      </div> <!-- span7 Left Pane -->

  </div> <!-- row -->
</div> <!-- content -->
