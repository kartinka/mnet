<div class="view">

    <div class="job">
        <h4 class="last-line-action"><?php echo $data->name; ?></h4>
        <h4><?php echo $data->location; ?>
            <?php if ($owner):?>
                <a id="edit_job" class="edit" data-id="<?php echo $data->id;?>" data-toggle="modal" data-target='#job-modal' href="<?php echo Yii::app()->baseUrl . '/job/edit/id/' . $data->id; ?>">Edit</a>
                <a class="edit" href="<?php echo Yii::app()->baseUrl . '/job/delete/id/' . $data->id; ?>">Delete</a></h4>
            <?php endif; ?>
        <div class="question-action">
            <?php echo $data->from; ?> - <?php echo ($data->to == '0000')? 'Present': $data->to; ?>
        </div>
    </div>

    <?php echo CHtml::ajaxLink('Edit ajax',
        Yii::app()->createUrl('job/edit'),
        array(
            'data'=>array('id'=>$data->id),
            'type'=>'post',
            'dataType'=> 'html',
            'success'=> 'function(html){jQuery("#job-modal-edit").html(html).modal(); return false;}',// 'function(html){jQuery("#qq").empty(); jQuery("#qq").html(html); $("#job-modal").modal(); return;}',
            array(
                'class' => 'namecard',
                'data-toggle'=>'modal',
                'data-target'=>'#job-modal-edit',
            ),
            array(
                'class' => 'namecard'
            )

        ));?>

</div>