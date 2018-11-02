<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput; // untuk memanggil fileinput yang sudah terinstall agar bisa mengupload data/file


/* @var $this yii\web\View */
/* @var $model app\models\Anggota */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggota-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telepon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'status_aktif')->textInput() ?> -->

    <?= $form->field($model, 'foto')->widget(FileInput::classname(),
        [
            'data' => $model->foto,
            'options' => ['multiple' => true],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
