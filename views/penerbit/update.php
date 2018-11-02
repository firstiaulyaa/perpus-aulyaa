<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Penerbit */

$this->title = 'Ubah Data Penerbit : ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penerbit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="penerbit-update">
<div class="box box-default">
<div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
