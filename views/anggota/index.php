<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnggotaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Anggota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggota-index">
    <div class="box box-default">
        <div class="box-header with-border">
            <div class="box-body">
                
            </div>
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

             <p>
        <?= Html::a('Tambah Anggota', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export ke Word', ['export-word'], ['class' => 'btn btn-info']); ?>

        <?= Html::a('Export ke Excel', ['export-excel'], ['class' => 'btn btn-success']); ?>

        <?= Html::a('Export ke PDF', ['site/export-pdf'], ['class' => 'btn btn-danger']); ?>
    </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' => 'text-align:center']
                    ], 
                    [
                            'attribute' => 'nama',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'format' => 'raw',
                            'contentOptions' => ['style' =>'text-align:left;'],
                    ],
                    [
                            'attribute' => 'alamat',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'format' => 'raw',
                            'contentOptions' => ['style' =>'text-align:left;'],
                    ],
                    [
                            'attribute' => 'telepon',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'format' => 'raw',
                            'contentOptions' => ['style' =>'text-align:left;'],
                    ],
                    [
                            'attribute' => 'email',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'format' => 'raw',
                            'contentOptions' => ['style' =>'text-align:left;'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'text-align:center;width:80px']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
