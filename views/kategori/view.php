<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kategori */

$this->title = $model->nama; // memanggil nama pada data kategori
$this->params['breadcrumbs'][] = ['label' => 'Kategori Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul di halaman kategori
?>

<!-- menampilkan view kategori -->
<div class="kategori-view">
<div class="box box-default">
<div class="box-body">


<!-- button ubah dan hapus satu data kategori -->
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
<!-- akhir button ubah dan hapus satu data kategori -->


<!-- menampilkan satu data kategori -->
    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'nama',
        ],
    ]) ?>
</div>
</div>
</div>
<!-- akhir menampilkan satu data kategori -->


<!-- menampilkan daftar buku berdasarkan kategori -->
<?php 


?>
<div>&nbsp;</div>
<div class="box box-default">
     <div class="box-header with-border">
        <h3 class="box-title">Daftar Buku</h3>
    </div>
<div class="box-body">
<table class="table table-bordered">
    <tr>
        <th style="text-align: center; width: 50px">No</th>
        <th style="text-align: center;">Nama Buku</th>
        <th style="text-align: center;">Penulis</th>
        <th style="text-align: center;">Penerbit</th>
        <th>&nbsp;</th>
    </tr>
    <?php $no=1; foreach ($model->findAllBuku() as $buku): ?>
    <tr>
        <td><?= $no; ?></td>
        <td><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></td>
        <td><?= Html::a($buku->penulis->nama, ['penulis/view', 'id' => $buku->id]); ?></td>
        <td><?= Html::a($buku->penerbit->nama, ['penerbit/view', 'id' => $buku->id]); ?></td>
    </tr>
    <?php $no++; endforeach ?>
</table>
</div>
</div>
<!-- akhir menampilkan daftar buku berdasarkan kategori -->
