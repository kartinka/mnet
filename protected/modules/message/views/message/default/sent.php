<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Messages:sent"); ?>
<?php
	$this->breadcrumbs=array(
		MessageModule::t("Messages"),
		MessageModule::t("Sent"),
	);
?>

<div class="row">
    <?php $this->renderPartial(Yii::app()->getModule('message')->viewPath . '/_navigation', array('active' => 'sent')) ?>

    <div class="span9 offset1">
        <h2><?php echo MessageModule::t('Sent'); ?></h2>

        <?php if ($messagesAdapter->data): ?>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'message-delete-form',
                'enableAjaxValidation'=>false,
                'action' => $this->createUrl('delete/'),
                'htmlOptions'=>array(
                'class'=>'well form-horizontal',
            ),

            )); ?>

            <table class="dataGrid">
                <tr>
                    <th  class="label"> To </th>
                    <th  class="label"> Subject </th>
                </tr>
                <?php foreach ($messagesAdapter->data as $index => $message): ?>
                    <tr>
                        <td>
                            <?php echo CHtml::checkBox("Message[$index][selected]"); ?>
                            <?php echo $form->hiddenField($message,"[$index]id"); ?>
                            <?php echo $message->getReceiverName() ?>
                        </td>
                        <td><a href="<?php echo $this->createUrl('view/', array('message_id' => $message->id)) ?>"><?php echo $message->subject ?></a></td>
                        <td><span class="date"><?php echo date(Yii::app()->getModule('message')->dateFormat, strtotime($message->created_at)) ?></span></td>
                    </tr>
                <?php endforeach ?>
            </table>

            <div class="row buttons">
                <?php echo CHtml::htmlButton('<i class="icon-remove icon-white"></i> ' . MessageModule::t("Delete Selected"), array('class'=>'btn btn-danger offset5', 'type'=>'submit')); ?>
            </div>

            <?php $this->endWidget(); ?>

            <?php $this->widget('CLinkPager', array('pages' => $messagesAdapter->getPagination())) ?>
        <?php endif; ?>
    </div>
</div>