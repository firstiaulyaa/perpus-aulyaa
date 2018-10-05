<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = $model->nama; // memanggil nama pada model anggota
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman anggota
?>

<div class="anggota-view">
<div class="box box-primary">
<div class="box-body"> 

<!-- button ubah dan hapus pada suatu data -->
    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapusnya?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<!-- akhir button ubah dan hapus pada suatu data -->

<!-- untuk melihat detailView pada data yang dipilih -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'alamat',
            'telepon',
            'email:email',
            'status_aktif',
        ],
    ]) ?>
<!-- akhir untuk melihat detailView pada data yang dipilih -->
</div>
</div>
</div>