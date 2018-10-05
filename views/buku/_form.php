<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; // untuk form
use yii\helpers\ArrayHelper; // memanggil ArrayHelper dari controller
use app\models\Kategori;  // untuk memanggil model kategori
use app\models\Penulis; // untuk memanggil model penulis
use app\models\Penerbit; // untuk memanggil model penerbit
use kartik\select2\Select2; // untuk memanggil select2 yang sudah terinstall agar data bisa menggunakan fitur pilihan (option)
use dosamigos\tinymce\TinyMce; // untuk memanggil tinymce yang sudah terinstall agar bisa menggunakan form dengan lengkap (tinymce)
use kartik\file\FileInput; // untuk memanggil fileinput yang sudah terinstall agar bisa mengupload data/file

/* @var $this yii\web\View */
/* @var $model app\models\Buku */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- form buku -->
<div class="buku-form">
<div class="box box-primary">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?> 

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tahun_terbit')->textInput(['maxlength' => true]) ?>

    <!-- penggunaan select2 dan getList -->
        <?= $form->field($model, 'id_penulis')->widget(Select2::classname(), [
                'data' =>  Penulis::getList(),
                'options' => [
                  'placeholder' => '- Pilih Penulis -',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

        <?= $form->field($model, 'id_penerbit')->widget(Select2::classname(), [
                'data' =>  Penerbit::getList(),
                'options' => [
                  'placeholder' => '- Pilih Penerbit -',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

        <?= $form->field($model, 'id_kategori')->widget(Select2::classname(), [
                'data' =>  Kategori::getList(),
                'options' => [
                  'placeholder' => '- Pilih Kategori -',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
    <!-- akhir penggunaan select2 dan getList -->


    <!-- penggunaan tinymce pada form sinopsis -->
        <?= $form->field($model, 'sinopsis')->widget(TinyMce::className(), [
            'options' => ['rows' => 6],
            'language' => 'en',
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste"
                ],
                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
        ]);?>
    <!-- akhir penggunaan tinymce pada form sinopsis -->
   


    <!-- penggunan file input pada sampul dan berkas -->
        <?= $form->field($model, 'sampul')->widget(FileInput::classname(), [
            'options' => ['accept'=>'sampul/*'],
            'pluginOptions'=>[
                'allowedFileExtensions'=>['jpg', 'png'], //bentuk file jpg dan png
                'showUpload' => true,
                'initialPreview' => [
                    $model->sampul ? Html::img($model->sampul) : null, // checks the models to display the preview
                ],
                'overwriteInitial' => false,
            ],
        ]); ?>

        <?= $form->field($model, 'berkas')->widget(FileInput::classname(), [
            'options' => ['accept'=>'berkas/*'],
            'pluginOptions'=>[
                'allowedFileExtensions'=>['pdf'], //bentuk file pdf
                'showUpload' => true,
                'initialPreview' => [
                    $model->berkas ? Html::img($model->berkas) : null, // checks the models to display the preview
                ],
                'overwriteInitial' => false,
            ],
        ]); ?>
    <!-- akhir penggunaan file input pada sampul dan berkas -->


    <!-- button simpan -->
        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    <!-- akhir button simpan dan data tersimpan di database -->

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
<!-- akhir form buku -->