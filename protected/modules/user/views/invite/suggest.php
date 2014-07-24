<div id="content">
    <div class="row">
        <div class="span7">
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$invitees,
                    'summaryText'=>'',
                    'ajaxUpdate'=>false,
                    'itemView'=> '_people',   // refers to the partial view named '_post'
                ));
            ?>
        </div> <!-- span7 Left Pane -->

        <div class="span4 offset1">


                <div class="form">
                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'invite-form',
                        'action'=>Yii::app()->createUrl("user/invite/byemail"),
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array(
                            'class'=>'well form-horizontal',
                        ),

                    )); ?>
                    <h3>Invite colleagues by email</h3>
                    <div style="font-style: italic">
                        Separate emails with comma
                    </div>
                    <br />
                    <?php if(Yii::app()->user->hasFlash('inviteFailed')): ?>
                        <div class="flash-error">
                            <?php echo Yii::app()->user->getFlash('inviteFailed'); ?>
                        </div>
                    <?php endif; ?>

                    <?php //echo $form->errorSummary($model); ?>

                    <div class="control-group">
                        <div>
                            <?php echo CHtml::label('Invitees ' . "<font style='color: red'>*</font>", 'invitees'); ?>
                        </div>
                        <div>
                            <?php echo CHtml::textArea('invitees', '', array('style' => 'width: 70%', 'rows' => '5')) ?>
                        </div>
                    </div>

                    <div>
                        <?php echo CHtml::htmlButton('Confirm', array('class'=>'btn', 'type'=>'submit')); ?>
                    </div>

                    <?php $this->endWidget(); ?>

        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->