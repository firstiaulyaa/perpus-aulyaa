<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategori Buku';
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman kategori
?>


<!-- menampilkan data kategori ke dalam tabel -->
<div class="kategori-index">
<div class="box box-default">
<div class="box-body">

    <p>
        <?= Html::a('Tambah Kategori Buku', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export ke Word', ['export-word'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('Export ke Excel', ['export-excel'], ['class' => 'btn btn-success btn-flat']); ?>

        <?= Html::a('Export ke PDF', ['kategori/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
            'class' => 'yii\grid\SerialColumn',
            'header' => 'No',
            'headerOptions' => ['style' => 'text-align:center'],
            'contentOptions' => ['style' => 'text-align:center']
            ],


            // 'id',
            'nama',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
<!-- akhir menampilkan data kategori ke dalam tabel -->
