<?php

use yii\helpers\Html;
use yii\grid\GridView; // untuk memanggil tampilan grid view
use app\models\Kategori; // untuk memanggil model kategori
use app\models\Penulis; // untuk memanggil model penulis
use app\models\Penerbit; // untuk memanggil model penerbit

/* @var $this yii\web\View */
/* @var $searchModel app\models\bukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Buku';
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman buku
?> 

<!-- menampilkan data buku dengan tabel -->
<div class="buku-index">
<div class="box box-default">
<div class="box-body">


    <p>
        <?= Html::a('Tambah Data Buku', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export ke Word', ['export-word'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('Export ke Excel', ['export-excel'], ['class' => 'btn btn-success btn-flat']); ?>

        <?= Html::a('Export ke PDF', ['buku/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>
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


            [
              'attribute' => 'nama',
              'headerOptions' => ['style' => 'text-align:center'],
              'format' => 'raw',
              'contentOptions' => ['style' =>'text-align:left;'],
            ],
            [
              'attribute' => 'tahun_terbit',
              'headerOptions' => ['style' => 'text-align:center'],
              'format' => 'raw',
              'contentOptions' => ['style' =>'text-align:center;'],
            ],
            [
                'attribute' => 'id_penulis',
                'format' => 'raw',
                'filter' => Penulis::getList(),
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align:left;'],
                'value' => function($data)
                {
                  return $data->penulis->nama;
                }
            ],
            [
                'attribute' => 'id_penerbit',
                'format' => 'raw',
                'filter' => Penerbit::getList(),
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align:left;'],
                'value' => function($data)
                {
                  return $data->penerbit->nama;
                }
            ],
            [
                'attribute' => 'id_kategori',
                'format' => 'raw',
                'filter' => Kategori::getList(),
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'value' => function($data)
                {
                  return $data->kategori->nama;
                }
            ],
            //'sinopsis:ntext',

            //sampul
            [
                'attribute' => 'sampul',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;'],
                'value' => function ($model) {
                  if ($model->sampul != '') {
                    return Html::img('@web/upload/sampul/' . $model->sampul, ['class' => 'img-responsive', 'style' => 'height:100px ']);
                  } else {
                    return '<div align="center"><h1>No Image</h1></div>';
                  }
                },
            ],

            //berkas

            [
                'attribute' => 'berkas',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;'],
                'value' => function ($model) {
                  if ($model->berkas !='') {
                    return '<a href="' . Yii::$app->request->baseUrl . '/upload/berkas/' . $model->berkas . '"><div align="center"><button class="btn btn-success glyphicon glyphicon-download-alt" type="submit"></button></div></a>';
                  } else {
                    return '<div align="center"><h1>No File</h1></div>';
                  }
                },
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'headerOptions' => ['style' => 'text-align:center'],
            ],
        ],
    ]); ?>
</div>
</div>
</div>
<!-- akhir menampilkan data buku dengan tabel -->