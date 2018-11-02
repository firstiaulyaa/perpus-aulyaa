<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="row">
	<center>
		<?= Html::img('@web/upload/sampul/' . @$model->buku->sampul, ['style'=>'height:250px', 'width:250px;']);?>
		<hr width="60%">
		<h3>Berhasil pinjam buku.</h3>
		<h3>Pada Tanggal </h3><h1><?= $model->tanggal_pinjam ?></h1>
		<p>Dengan nama buku : <b><h2><?= @$model->buku->nama; ?></h2></b></p>
		<p>Terima kasih sudah mengunjungi perpusJJ.</p>
		<hr width="60%">
	</center>
</div>