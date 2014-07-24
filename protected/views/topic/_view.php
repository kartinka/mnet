<?php if ($data->answers_number>0):?>
    <div class="view">

        <div class="question-headline">
            <?php echo CHtml::link($data->question, Yii::app()->baseUrl.'/question/view/id/'.$data->q_id); ?>
        </div>
        <div>
            <?php echo CHtml::encode($data->detail); ?>
        </div>


        <div class="post-infoblock">
            <?php if ($data->profile_picture != ''): ?>

                <div style="float:left">
                    <img border="1" style="padding-right: 8px ;max-width:50px;max-height:50px;" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture?>" alt="profile picture" />
                </div>
            <?php endif; ?>

            <div class='boxbyphoto'>
                <div class='question-nonboldaction'>
                    <b>New answer</b>
                    <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$data->a_create_at);?>
                </div>
                <div class='question-detail'>
                    <?php echo $data->answer ?>...
                </div>
                <div class='question-nonboldaction'>
                    <b><a target="_blank" href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->answerer?>"><?php echo $data->firstname. ' ' . $data->lastname?></a></b>, <?php echo $data->location?>
                </div>

            </div>
        </div>
        <div style="clear:both"></div>
        <div class="last-line-action">

            <a href="javascript:void(0)" class="t" onclick="follow('<?php echo $data->q_id?>','Q','link','long');" id="followQ<?php echo $data->q_id?>" >Follow Question</a>
            &bull;
            <a href="javascript:void(0)" class="t" onclick="follow('<?php echo $data->answerer?>','P','link','long');" id="followP<?php echo $data->answerer?>" >Follow User</a>
            &bull;&nbsp;
            <?php
            $answers = ($data->answers_number>1)?' Answers':' Answer';
            echo CHtml::link($data->answers_number . $answers . ' available', Yii::app()->baseUrl.'/question/view/id/'.$data->q_id);
            ?>
        </div>
    </div>
    <br />

<?php else: ?>

    <div class="view">

        <div class="question-headline">
            <?php echo CHtml::link($data->question, Yii::app()->baseUrl.'/question/view/id/'.$data->q_id); ?>
        </div>
        <div>
            <?php echo CHtml::encode($data->detail); ?>
        </div>


        <div class="post-infoblock">
            <?php if ($data->profile_picture != ''): ?>
                <div style="float:left">
                    <img border="1" style="padding-right: 8px ;max-width:50px;max-height:50px;" src="<?php echo Yii::app()->baseUrl.'/images/profile/'.$data->profile_picture?>" alt="profile picture" />
                </div>
            <?php endif; ?>
            <div class='boxbyphoto'>
                <div class='question-nonboldaction'>
                    <b>New question</b>
                    <?php echo Yii::app()->dateFormatter->format("MMMM dd, yyyy",$data->q_create_at);?>
                </div>
            </div>
            <?php if ($data->inquirer != '-1'): ?>
                <div class='question-nonboldaction'>
                    <b><a target="_blank" href="<?php echo Yii::app()->baseUrl.'/user/user/view/id/'.$data->inquirer?>"><?php echo $data->firstname. ' ' . $data->lastname?></a></b>, <?php echo $data->location?>
                </div>
            <?php endif;?>
        </div>

        <div style="clear:both"></div>
        <div class="last-line-action">

            <a href="javascript:void(0)" class="t" onclick="follow('<?php echo $data->q_id?>','Q','link','long');" id="followQ<?php echo $data->q_id?>" >Follow Question</a>
            &bull;
            <a href="javascript:void(0)" class="t" onclick="follow('<?php echo $data->inquirer?>','P','link','long');" id="followP<?php echo $data->inquirer?>" >Follow User</a>
            &bull;&nbsp;
            <?php echo CHtml::link('0 Answers available', Yii::app()->baseUrl.'/question/view/id/'.$data->q_id); ?>
        </div>

    </div>
    <br />
<?php endif; ?>