    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Edit position</h4>
    </div>

    <div class="modal-body">
        <div class="form">
            <?php $this->renderPartial('/job/_form', array('model'=>$model, 'user_id'=> Yii::app()->user->id )); ?>
        </div><!-- form -->

    </div>