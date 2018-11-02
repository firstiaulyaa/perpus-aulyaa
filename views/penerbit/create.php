<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Penerbit */

$this->title = 'Tambah Data Penerbit';
$this->params['breadcrumbs'][] = ['label' => 'Penerbit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerbit-create">
<div class="box box-default">
<div class="box-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
