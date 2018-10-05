<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kategori */

$this->title = 'Tambah Kategori Buku';
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman kategori
?>
<div class="kategori-create">
<div class="box box-primary">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
