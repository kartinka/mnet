        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'Job',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'focus'=>array($model,'name'),
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->hiddenField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
            <?php //echo CHtml::hiddenField('user_id', $user_id); ?>
        </div>

        <div class="control-group">
            <div class="control-label">
                <?php echo $form->labelEx($model,'name'); ?>
            </div>
            <div class="controls">
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                <?php echo $form->labelEx($model,'location'); ?>
            </div>
            <div class="controls">
                <?php echo $form->textField($model,'location',array('rows'=>6, 'cols'=>30, 'style'=>'width: 70%%')); ?>
                <?php echo $form->error($model,'location'); ?>
            </div>
        </div>

        <div class="control-label">
            <?php echo CHtml::label('Period of working', ''); ?>
        </div>

        <div class="control-group" style="width: 50%; float: left">
            <div class="control-label">
                <?php echo $form->labelEx($model,'from'); ?>
            </div>

            <div class="controls">
                <?php echo $form->dropDownList($model,'from', array_combine(range(1950, date('Y', strtotime('+0 year'))), range(1950, date('Y', strtotime('+0 year')))), array('style'=>'width: 40%%')); ?>
                <?php echo $form->error($model,'from'); ?>
            </div>
        </div>

        <div class="control-group" style="margin-left: 55%">
            <div class="control-label">
                <?php echo $form->labelEx($model,'to'); ?>
            </div>
            <div class="controls">
                <?php echo $form->dropDownList($model,'to', array_merge(array_combine(range(1950, date('Y', strtotime('+0 year'))), range(1950, date('Y', strtotime('+0 year')))), array('0000' => 'Present')), array('style'=>'width: 40%%')); ?>
                <?php echo $form->error($model,'to'); ?>
            </div>

        </div>

        <div class="modal-footer">
            <?php if (!Yii::app()->request->isAjaxRequest): ?>
                <div class="row buttons ">
                    <?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                    <button class="btn btn-success" id="submit">submit</button>
                </div>

            <?php else: ?>
                <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                    'type'=>'info',
                    'buttonType'=>'submit',
                    'label'=>$model->isNewRecord? 'Create': 'Save', //($model->jobs->isNewRecord ? 'Save' : 'Update'),
                    'ajaxOptions'=>array(
                        'type'=>'POST', //request type
                        'data'=>'js:jQuery(this).parents(".form").serialize()',
                        'success'=>'function(r){
                                if(r=="success"){
                                    window.location.reload();
                                }
                                else{
                                    $("#job-modal-create").html(r).modal(); return false;
                                }
                            }',
                        'url' => $model->isNewRecord? Yii::app()->createUrl('job/create'): Yii::app()->createUrl('job/edit'), // ,
                    ),
                    //'url' => '#',
                    //'htmlOptions'=>array('onclick' => '$("#Job").submit()'),
                    'htmlOptions'=>array('data-dismiss'=>'modal') // , 'onclick' => '$("#Job").submit()'),
                )); */ ?>
                <button class="btn btn-success" id="submit">submit</button>
            <?php endif; ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Cancel',
                'htmlOptions'=>array('data-dismiss'=>'modal'),
            )); ?>
        </div>

        <?php $this->endWidget(); ?>

