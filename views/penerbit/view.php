<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Penerbit */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penerbit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerbit-view">
<div class="box box-primary">
<div class="box-body">

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
            'id',
            'nama',
            'alamat:ntext',
            'telepon',
            'email:email',
        ],
    ]) ?>
</div>
</div>
</div>

<div>&nbsp;</div>
<h3>Daftar Buku</h3>
<div class="box box-primary">
<div class="box-body">
<table class="table">
    <tr>
        <th>No</th>
        <th>Nama Buku</th>
        <th>&nbsp;</th>
    </tr>
    <?php $no=1; foreach ($model->findAllBuku() as $buku): ?>
    <tr>
        <td><?= $no; ?></td>
        <td><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></td>
        <td>
            <?= Html::a("Ubah", ["buku/update","id"=>$buku->id], ['class' => 'btn btn-primary']); ?> &nbsp;
            <?= Html::a("Hapus", ["buku/delete","id"=>$buku->id], ['class' => 'btn btn-danger'], ['data-method' => 'post', 'data-confirm' => 'Hapus data ?']); ?> &nbsp;
        </td>
    </tr>
    <?php $no++; endforeach ?>
</table>
</div>
</div>