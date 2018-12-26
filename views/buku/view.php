<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Kategori;
use app\models\Penulis;
use app\models\Penerbit;
use app\models\Buku;
use app\models\Peminjaman;

/* @var $this yii\web\View */
/* @var $model app\models\Buku */

// kalau mau ada teks (misal: Buku)sebelum pemanggilan nama
// $this->title = "Buku : " . $model->nama;

$this->title = $model->nama; // memanggil nama dari data buku
$this->params['breadcrumbs'][] = ['label' => 'Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman buku
?>

<?php if (Yii::$app->user->identity->id_user_role == 1): ?>
<!-- menampilkan view buku -->
<div class="buku-view">
<div class="box box-default">
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
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            // 'id',
            [
                'label' => 'Nama Buku',
                // 'attribute' => 'nama',
                'value' => $model->nama
            ],
                        [
                'label' => 'Tahun Terbit',
                // 'attribute' => 'nama',
                'value' => $model->tahun_terbit
            ],
            [
               'label' => 'Penulis',
               'value' => function($data)
                {
                  return $data->penulis->nama;
                }
           ],
            [
               'label' => 'Penerbit',
               'value' => function($data)
                {
                  return $data->penerbit->nama;
                }
           ],
            [
               'label' => 'Kategori',
               'value' => function($data)
                {
                  return $data->kategori->nama;
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
<?php endif ?>

<?php if (Yii::$app->user->identity->id_user_role == 3): ?>
<!-- menampilkan view buku -->
<div class="buku-view">
<div class="box box-default">
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
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            // 'id',
            [
                'label' => 'Nama Buku',
                // 'attribute' => 'nama',
                'value' => $model->nama
            ],
                        [
                'label' => 'Tahun Terbit',
                // 'attribute' => 'nama',
                'value' => $model->tahun_terbit
            ],
            [
               'label' => 'Penulis',
               'value' => function($data)
                {
                  return $data->penulis->nama;
                }
           ],
            [
               'label' => 'Penerbit',
               'value' => function($data)
                {
                  return $data->penerbit->nama;
                }
           ],
            [
               'label' => 'Kategori',
               'value' => function($data)
                {
                  return $data->kategori->nama;
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
<?php endif ?>

<?php if (Yii::$app->user->identity->id_user_role == 2): ?>
<!-- menampilkan view buku -->
<div class="buku-view">
<div class="box box-default">
<div class="box-body">

<!-- menampilkan satu data buku -->
     <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            // 'id',
            [
                'label' => 'Nama Buku',
                // 'attribute' => 'nama',
                'value' => $model->nama
            ],
                        [
                'label' => 'Tahun Terbit',
                // 'attribute' => 'nama',
                'value' => $model->tahun_terbit
            ],
            [
               'label' => 'Penulis',
               'value' => function($data)
                {
                  return $data->penulis->nama;
                }
           ],
            [
               'label' => 'Penerbit',
               'value' => function($data)
                {
                  return $data->penerbit->nama;
                }
           ],
            [
               'label' => 'Kategori',
               'value' => function($data)
                {
                  return $data->kategori->nama;
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
<?php endif ?>
<!-- akhir menampilkan view buku -->