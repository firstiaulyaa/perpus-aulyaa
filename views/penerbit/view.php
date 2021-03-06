<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Buku;
use app\models\Penulis;

/* @var $this yii\web\View */
/* @var $model app\models\Penerbit */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penerbit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerbit-view">
<div class="box box-default">
<!--     <div class="box-header with-border">
        <h3 class="box-title">Profil</h3>
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
        <th style="text-align: center;">Penulis</th>
    </tr>
    </thead>
    <?php $no=1; foreach ($model->findAllBuku() as $buku): ?>
    <tr>
        <td><?= $no; ?></td>
        <td><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></td>
        <td><?= Html::a($buku->penulis->nama, ['penulis/view', 'id' => $buku->id_penulis]); ?></td>
    </tr>
    <?php $no++; endforeach ?>
</table>
</div>
</div>