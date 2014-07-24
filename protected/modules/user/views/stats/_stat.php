<div class="view">

    <div class="question-headline">
        <?php echo CHtml::link($data->question_text, Yii::app()->baseUrl.'/question/view/id/'.$data->question_id); ?>
    </div>
    <div>
        <?php echo CHtml::encode(substr($data->answer_text, 0, 200)) . '...'; ?>
    </div>
    <br />

    <div>
        Viewed <b><?php echo $data->views?></b> by <b><?php echo $data->user_number?></b> people at the following <b><?php echo $data->jobs_number?></b> institutions:
    </div>

    <div>
        <ul>
        <?php
            $counter = 0;
            foreach($data->jobs as $job): ?>
                <?php $counter++; ?>
                    <?php if ($counter == 4):?>
                        <li> <?php echo CHtml::link('(See all)', '', array('style' => 'cursor: pointer', 'onclick' => 'javascript: $(".invisible").removeClass("invisible")')) ?> </li>
                    <?php endif; ?>
                <?php if ($counter>3):?>
                    <li class="invisible"> <?php echo $job; ?> </li>
                <?php else: ?>
                    <li> <?php echo $job; ?> </li>
                <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<br />
