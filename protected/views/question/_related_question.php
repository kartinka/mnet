    <li>
        <a href="<?php echo Yii::app()->baseUrl.'/question/view/'.$data->id?>">
            <div class="last-line-action">
                <?php echo $data->text?>
            </div>
            <?php if (trim($data->detail) != ''):?>
                <div class="p-pubitemdetail">
                    <?php echo substr($data->detail, 0, 50 );?> ...
                </div>
            <?php endif; ?>
        </a>
    </li>

