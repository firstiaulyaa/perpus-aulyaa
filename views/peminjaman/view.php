<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Anggota;
use app\models\Buku;

/* @var $this yii\web\View */
/* @var $model app\models\Peminjaman */

$this->title = 'Peminjam : ' . $model->anggota->nama;
$this->params['breadcrumbs'][] = ['label' => 'Peminjamen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-view">
<div class="buku-view">
<div class="box box-default">
<div class="box-body">

    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            [
               'label' => 'Buku',
               'value' => function($data)
                {
                  return $data->buku->nama;
                }
            ],
            [
               'label' => 'Nama Anggota',
               'value' => function($data)
                {
                  return $data->anggota->nama;
                }
            ],
            [
                'attribute' => 'tanggal_pinjam',
                'format' => ['DateTime', 'php: D, d  F  Y'],
                'label' => 'Tanggal Pinjam',
                'encodeLabel' => false
            ],
            [
                'attribute' => 'tanggal_kembali',
                'format' => ['DateTime', 'php: D, d  F  Y'],
                'label' => 'Tanggal Kembali',
                'encodeLabel' => false
            ],
            [
                'attribute' => 'status_buku',
                'value' => function ($model) {
                    if ($model->status_buku == 0) {
                        return "Dikembalikan";
                    } else {
                        return "Belum Dikembalikan";
                    }
                }
            ],
            [
                'attribute' => 'tanggal_pengembalian_buku',
                'format' => ['DateTime', 'php: D, d  F  Y'],
                'label' => 'Tanggal Pengembalian Buku',
                'encodeLabel' => false
            ],
        ],
    ]) ?>
</div>
</div>
</div>
</div>
