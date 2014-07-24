<div id="content">
    <div class="row">
        <div class="span7">
            <div class="well" >
                <div class="boxhilight">
                    <h2>All users</h2>
                </div>
            </div>
            <div class="well">
                <?php
                if ($users)
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$users,
                        'itemView'=> '_user',   // refers to the partial view named '_post'
                    ));
                else
                    echo "No registered users found."
                ?>
            </div>
        </div> <!-- span7 Left Pane -->

    </div> <!-- row -->
</div> <!-- content -->