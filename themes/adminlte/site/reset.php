<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Reset Password',
);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'coba-form',
	'enableAjaxValidation'=>false,
)); ?>

        <div class="row">
                <?php echo Chtml::label('Old Password',''); ?>
		<?php echo Chtml::passwordField('oldpassword'); ?>
	</div>

	
	<div class="row">
		<?php echo Chtml::label('New Password',''); ?>
		<?php echo Chtml::passwordField('newpassword'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Reset Password'); ?>
	</div>
<?php $this->endWidget(); ?>