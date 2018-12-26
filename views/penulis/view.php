<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Buku;
use app\models\Penerbit;

/* @var $this yii\web\View */
/* @var $model app\models\Penulis */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penulis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penulis-view">
<div class="box box-default">
<!--      <div class="box-header with-border">
        <h3 class="box-title">Detail</h3>
    </div> -->
<div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'group' => true,
                'label' => 'Profil',
                'rowOptions' => ['class' => 'bg-blue'],
                //'groupOptions' => ['class' => 'text-center']
            ],
            'id',
            'nama',
            'alamat:ntext',
            'telepon',
            'email:email',
            [
                'label' => 'Jumlah Buku',
                'value' => $model->getJumlahBuku()
            ]
        ],
    ]) ?>

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

</div>
</div>
</div>

<div>&nbsp;</div>
<div class="box box-default">
     <div class="box-header with-border">
        <h3 class="box-title">Daftar Buku</h3>
    </div>
<div class="box-body">
<table class="table table-bordered table-hover">
    <thead class="bg-blue">
    <tr>
        <th style="text-align: center; width: 50px">No</th>
        <th style="text-align: center;">Nama Buku</th>
        <th style="text-align: center;">Penerbit</th>
    </tr>
    </thead>
    <?php $no=1; foreach ($model->findAllBuku() as $buku): ?>
    <tr>
        <td><?= $no; ?></td>
        <td><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></td>
        <td><?= Html::a($buku->penerbit->nama, ['penerbit/view', 'id' => $buku->id_penerbit]); ?></td>
    </tr>
    <?php $no++; endforeach ?>
</table>
</div>
</div>