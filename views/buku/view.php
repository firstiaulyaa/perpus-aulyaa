<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Kategori;
use app\models\Penulis;
use app\models\Penerbit;


/* @var $this yii\web\View */
/* @var $model app\models\Buku */

// kalau mau ada teks (misal: Buku)sebelum pemanggilan nama
// $this->title = "Buku : " . $model->nama;

$this->title = $model->nama; // memanggil nama dari data buku
$this->params['breadcrumbs'][] = ['label' => 'Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman buku
?>

<!-- menampilkan view buku -->
<div class="buku-view">
<div class="box box-primary">
<div class="box-body">

<!-- button ubah dan hapus satu data buku -->
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
<!-- button ubah dan hapus satu data buku -->

<!-- menampilkan satu data buku -->
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'Nama (Tahun)',
                // 'attribute' => 'nama',
                'value' => $model->nama . ' (' . $model->tahun_terbit . ')'
            ],
            [
                'attribute' => 'tahun_terbit',
                // Masehi -> untuk penambahan kata masehi dibelakang tahun
                'value' => $model->tahun_terbit //. ' Masehi'
            ],
            [
               'label' => 'Penulis',
               'value' => function($data)
                {
                  return $data->getPenulis();
                }
           ],
            [
               'label' => 'Penerbit',
               'value' => function($data)
                {
                  return $data->getPenerbit();
                }
           ],
            [
               'label' => 'Kategori',
               'value' => function($data)
                {
                  return $data->getKategori();
                }
           ],
            'sinopsis:ntext',
            [
                'label' => 'Sampul',
                'format' => 'raw',
                'value' => function ($model) {
                  if ($model->sampul != '') {
                    return Html::img('@web/upload/sampul/' . $model->sampul, ['class' => 'img-responsive', 'style' => 'height:300px ']);
                  } else {
                    return '<div align="center"><h1>No Image</h1></div>';
                  }
                },
            ],
            'berkas',
        ],
    ]) ?>
</div>
</div>
</div>
<!-- akhir menampilkan satu data buku -->
<!-- akhir menampilkan view buku -->