<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Anggota */

$this->title = $model->nama; // memanggil nama pada model anggota
$this->params['breadcrumbs'][] = ['label' => 'Anggota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman anggota
?>

<div class="anggota-view">
<div class="box box-default">
<div class="box-body">  

<?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'nama',
            'alamat',
            'telepon',
            'email:email',
            [
                'attribute' => 'status_aktif',
                'value' => function ($model) {
                    if ($model->status_aktif == 1) {
                        return "Aktif";
                    } else {
                        return "Tidak";
                    }
                }
            ],
        ],
    ]) ?>

</div>
</div>
</div>