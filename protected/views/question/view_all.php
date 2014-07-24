<div id="content">
    <div class="row">
        <div class="span7">
            <div class="well" >
                <div class="boxhilight">
                    <h2>All questions</h2>
                </div>
            </div>

            <div class="well" >

                <?php
                    if ($questions_answered)
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$questions_answered,
                            'summaryText'=>'',
                            'itemView'=> '/topic/_answered',   // refers to the partial view named '_post'
                        ));
                ?>

                <?php
                    if ($questions_unanswered)
                        $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$questions_unanswered,
                        'summaryText'=>'',
                        'itemView'=> '/topic/_unanswered',   // refers to the partial view named '_post'
                    ));
                ?>
                <?php if (!$questions_answered and !$questions_unanswered): ?>
                    No questions related to this topic.
                <?php endif; ?>
            </div>
        </div> <!-- span7 Left Pane -->

    </div> <!-- row -->
</div> <!-- content -->