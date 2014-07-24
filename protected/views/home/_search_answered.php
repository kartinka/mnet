<div class="view">

    <div class="question-headline">
        <?php echo CHtml::link($data->text, Yii::app()->baseUrl.'/question/view/id/'.$data->id); ?>
    </div>
    <div>
        <?php echo CHtml::encode($data->detail); ?>
    </div>

    <div class="last-line-action">
        <?php
            $answers = ($data->answersCount>1)?' Answers':' Answer';
            echo CHtml::link($data->answersCount . $answers . ' available', Yii::app()->baseUrl.'/question/view/id/'.$data->id);
        ?>
    </div>
    <div style="clear:both"></div>
</div>

<br />
