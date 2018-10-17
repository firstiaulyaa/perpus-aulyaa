<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use app\models\Buku;
use app\models\Anggota;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PeminjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Peminjaman';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-index">
<div class="box box-primary">
<div class="box-header with-border">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
<div class="box-body">

    <p>
        <?= Html::a('Tambah Data Peminjaman', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export ke Word', ['export-word'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('Export ke Excel', ['export-excel'], ['class' => 'btn btn-success btn-flat']); ?>

        <?= Html::a('Export ke PDF', ['site/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'id_buku',
                'format' => 'raw',
                'filter' => Buku::getList(),
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
                'value' => function($data)
                {
                  return $data->buku->nama;
                }
            ],
            [
                'attribute' => 'id_anggota',
                'format' => 'raw',
                'filter' => Anggota::getList(),
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'value' => function($data)
                {
                  return $data->anggota->nama;
                }
            ],
            [
                'attribute' => 'tanggal_pinjam',
               'format' => 'date',
               'encodeLabel' =>false,
               'headerOptions' => ['style' => 'text-align:center; width: 200px'],
               'contentOptions' => ['style' => 'text-align:center'],
            ],
            [
               
               'attribute' =>'tanggal_kembali',
               'format' => 'date',
               'encodeLabel' =>false,
               'headerOptions' => ['style' => 'text-align:center; width: 200px'],
               'contentOptions' => ['style' => 'text-align:center'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
