<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'share-modal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Add a position</h4>
</div>

<div class="modal-body">
    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'share-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false

        )); ?>


        <div class="modal-footer">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Cancel',
                'htmlOptions'=>array('data-dismiss'=>'modal'),
            )); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->

</div>

<?php $this->endWidget(); ?>



