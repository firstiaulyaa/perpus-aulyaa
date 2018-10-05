<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Buku */

$this->title = 'Ubah Data Buku : ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->nama]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="buku-update">
<div class="box box-primary">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
