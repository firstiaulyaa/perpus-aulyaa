<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = 'Tambah Data Anggota';
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman anggota
?>
<div class="anggota-create">
<div class="box box-primary">
<div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
