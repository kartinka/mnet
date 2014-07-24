<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>
<h1><?php echo UserModule::t('Edit profile'); ?></h1>
<br />
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="span7">

		<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'profile-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'well form-horizontal'),
		)); ?>

			<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

			<?php echo $form->errorSummary(array($model,$profile)); ?>

		<?php
				$profileFields=$profile->getFields();
				if ($profileFields) {
					foreach($profileFields as $field) {
					?>
                <div class="control-group">
                    <div class="control-label">
				        <?php
                            if ($field->varname != 'invite_code')
                                echo $form->labelEx($profile,$field->varname);
                        ?>
                    </div>
                    <div class="controls">
                      <?php if ($widgetEdit = $field->widgetEdit($profile)) {
                            echo $widgetEdit;
                        } elseif ($field->range) {
                            echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
                        } elseif ($field->field_type=="TEXT") {
                            //echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
                            $this->widget('application.extensions.tinymce.ETinyMce',
                                array(
                                    'model'=>$profile,
                                    'attribute'=>'interests',
                                    //'editorTemplate'=>'full',
                                    'skin'=>'cirkuit',
                                    'useSwitch' => false,
                                    'useCompression'=>false,
                                    'options'=> array(
                                        'mode' =>"textareas",
                                        'theme' => 'advanced',
                                        'skin' => 'cirkuit',
                                        'theme_advanced_toolbar_location'=>'top',
                                        'plugins' => 'spellchecker,safari,pagebreak,style,layer,save,advlink,advlist,iespell,inlinepopups,insertdatetime,contextmenu,directionality,noneditable,nonbreaking,xhtmlxtras,template',
                                        'theme_advanced_buttons1' => 'bold,italic,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,|,spellchecker',
                                        'theme_advanced_buttons2' => '',
                                        'theme_advanced_buttons3' => '',
                                        'theme_advanced_toolbar_location' => 'top',
                                        'theme_advanced_toolbar_align' => 'left',
                                        'theme_advanced_statusbar_location' => 'bottom',
                                        'theme_advanced_resizing_min_height' => 30,
                                        'height' => 300
                                    ),
                                    'htmlOptions'=>array('rows'=>5, 'cols'=>30, 'class'=>'tinymce'),
                                ));


                        } elseif ($field->list) { // a checkbox list
                            $values = explode(';', $field->list);
                            $values_list = array();
                            foreach ($values as $key => $value) {
                                $values_list[$value] = $value;
                            }
                          $profile->{$field->varname} = explode(';', $profile->{$field->varname}); //(is_array($profile->{$field->varname}))?explode(';', $profile->{$field->varname}): $profile->{$field->varname};
                          if ($field->varname == 'degrees') {
                              echo $form->checkboxList($profile, $field->varname, $values_list,
                                  array('separator'=>' ',
                                      'template'=>'<label class="checkbox inline">{input}{label}</label>',
                                      'labelOptions' =>
                                          array('style' => "display: inline", 'margin-right: 10px')
                              ));
                          } else {
                              echo $form->checkboxList($profile, $field->varname, $values_list,
                                  array('separator'=>' ',
                                      'template'=>'<label class="checkbox">{input}{label}</label>',
                                      'labelOptions' =>
                                          array('style' => "display: inline", 'margin-right: 10px')
                                  ));
                            }
                          } else {

                          if ($field->varname != 'invite_code')
                                echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
                        }
                        echo $form->error($profile,$field->varname); ?>
                    </div>
                </div>
					<?php
					}
				}
		?>
            <div class="control-group">
                <div class="control-label">
                    <?php echo $form->labelEx($model,'email'); ?>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>
			</div>

			<div class="form-actions">
                <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> ' . 'Save', array('class'=>'btn btn-info', 'type'=>'submit')); ?>
				<?php //echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
	</div>

    <div class="span4 offset1">
        <div class="list-group">
            <a href="<?php echo Yii::app()->baseUrl?>/user/user/view/id/me" class="list-group-item"></i> My profile </a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/edit" class="list-group-item active"><i class="icon-chevron-left"></i> Edit Account details</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/changepassword" class="list-group-item">Change Password</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/profile/pictureupload" class="list-group-item">Update Profile Picture</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/notifications/edit" class="list-group-item">Email Preferences</a>
            <a href="<?php echo Yii::app()->baseUrl?>/user/following/topicfeed" class="list-group-item">Feed Settings</a>
        </div>
    </div>
</div>

