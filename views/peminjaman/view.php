<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Buku;
use app\models\Anggota;

/* @var $this yii\web\View */
/* @var $model app\models\Peminjaman */

$this->title = $model->anggota->nama;
$this->params['breadcrumbs'][] = ['label' => 'Peminjaman', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-view">
  <div class="box box-primary">
<div class="box-body">

  <h1><?= Html::encode($this->title) ?></h1>

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

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            // 'id',
      [
        'attribute' => 'id_anggota',
        'value' => $model->anggota->nama
      ],
      [
        'attribute' => 'id_buku',
        'value' => $model->buku->nama
      ],

      [
        'attribute' => 'tanggal_pinjam',
        'value' => $model->tanggal_pinjam
      ],
      [
        'attribute' => 'tanggal_kembali',
        'value' => $model->tanggal_kembali
      ],
    ],
  ]); ?>


</div>
</div>
</div>
