<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Buku */

$this->title = 'Tambah Data Buku';
$this->params['breadcrumbs'][] = ['label' => 'Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // memanggil judul dari halaman bukuu
?>

<div class="buku-create">
<div class="box box-primary">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>