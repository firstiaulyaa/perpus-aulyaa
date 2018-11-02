<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Anggota;
use app\models\Petugas;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Detail Akun : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
<div class="box box-default">

<div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'group' => true,
                'label' => 'Akun',
                'rowOptions' => ['class' => 'bg-blue'],
                //'groupOptions' => ['class' => 'text-center']
            ],
            'id',
            [
                'attribute' => 'id_anggota',
                'label' => 'ID Anggota',
                'format' => 'raw',
                'value' => $model->id_anggota,
            ],
            [
                'attribute' => 'id_petugas',
                'label' => 'ID Petugas',
                'format' => 'raw',
                'value' => $model->id_petugas,
            ],
            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => $model->username,
            ],
             [
                'attribute' => 'password',
                'format' => 'raw',
                'value' => $model->password,
            ],
             [
                'attribute' => 'id_user_role',
                'format' => 'raw',
                'value' => $model->id_user_role,
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->status,
            ],
        ],
    ]) ?>
<div class="box-body">
        <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
</div>
