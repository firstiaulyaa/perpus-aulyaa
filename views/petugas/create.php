<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Petugas */

$this->title = 'Tambah Data Petugas';
$this->params['breadcrumbs'][] = ['label' => 'Petugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="petugas-create">
<div class="box box-primary">
<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
