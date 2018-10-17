<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Lupa Password';

$email = [
   'options' => ['class' => 'form-group has-feedback'],
   'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

?>

<div class="login-box">
   <div class="login-logo">
       <a href="#">myLibrary</a>
   </div>
   <!-- /.login-logo -->
   <div class="login-box-body">
       <p class="login-box-msg">Masukkan Email Anda</p>

       <?php $form = ActiveForm::begin(['id' => 'forget', 'enableClientValidation' => false]); ?>

       <?= $form
           ->field($model, 'email', $email)
           ->label(false)
           ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

       <?= $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

       <div class="row">
           <!-- /.col -->
           <div class="col-xs-12">
               <div class="col-xs-6">
                   <button type="button" class="btn btn-default btn-block btn-flat" onclick="history.back()"><i class="fa fa-arrow-left"></i> Kembali</button>
               </div>
               <div class="col-xs-6">
                   <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
               </div>
           </div>
           <!-- /.col -->
       </div>


       <?php ActiveForm::end(); ?>

   <!-- /.login-box-body -->
</div><!-- /.login-box -->