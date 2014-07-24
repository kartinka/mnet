    <li>
        <a href="<?php echo Yii::app()->baseUrl.'/question/view/'.$data->question->id?>">
            <div class="last-line-action" style="color: #1b1f50">
                <?php echo $data->question->text?>
            </div>
            <div class="p-pubitemdetail">
                <span style="color: #696e6f">Posted answer</span>
                <br />
                <?php echo substr($data->text, 0, 50 );?> ...
            </div>
        </a>
    </li>

