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
     <div class="box-header with-border">
        <h3 class="box-title">Profil</h3>
    </div>
<div class="box-body">


<!-- button ubah dan hapus pada suatu data -->
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
<!-- akhir button ubah dan hapus pada suatu data -->

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
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