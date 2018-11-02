<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KenaikanDendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kenaikan Denda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kenaikan-denda-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Kenaikan Denda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No',
                'contentOptions' => ['style'=>'text-align:center'],
                'headerOptions' => ['style'=>'text-align:center', 'width' => 20]
            ],

            // 'id',
            'hari',
            'harga',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'text-center']
            ],
        ],
    ]); ?>
</div>
