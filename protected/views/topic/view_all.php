<div id="content">
    <div class="row">
        <div class="span7">
            <div class="well" >
                <div class="boxhilight">
                    <h2>All topics</h2>
                </div>
            </div>

            <div class="well">

                <?php
                if ($topics)
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$topics,
                        'ajaxUrl'=> Yii::app()->baseUrl . '/topic/view/id/all',
                        'itemView'=> '_topic',   // refers to the partial view named '_post'
                    ));
                else
                    echo "No topics found."
                ?>
            </div>

        </div> <!-- span7 Left Pane -->

    </div> <!-- row -->
</div> <!-- content -->