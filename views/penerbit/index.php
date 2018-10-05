<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\penerbitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penerbit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerbit-index">
<div class="box box-primary">
<div class="box-body">

    <p>
        <?= Html::a('Tambah Data Penerbit', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export ke Word', ['export-word'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('Export ke Excel', ['export-excel'], ['class' => 'btn btn-success btn-flat']); ?>

        <?= Html::a('Export ke PDF', ['site/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nama',
            'alamat:ntext',
            'telepon',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
