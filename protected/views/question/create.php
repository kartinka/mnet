<?php
/* @var $this QuestionController */
/* @var $model Question */

/*
$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
*/
?>
<div id="content">
    <div class="row">

        <div class="span7">
            <div class="well">
                <?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div> <!-- span7 Left Pane-->
        <div class="span4 offset1">
            <div class="well" style="border: 3px solid black;">
                <b>Guidelines for writing a good question</b><br><br>
                <ul>
                    <li>Questions should use proper grammar and be formatted in the form of a question</li>
                    <li>Questions should be open ended and provoke broad based reusable answers</li>
                    <li>Questions should not be case-based or contain any patient identifiable information. Case based questions will not be accepted.</li>
                    <li>Questions may be edited for clarity or rephrased to garner the most constructive answers</li>
                </ul>
            </div>

        </div> <!-- span4 Right Pane-->
    </div> <!-- row -->
</div> <!-- content -->

