<?php

use yii\helpers\Url;
use yii\helpers\Html;
// use app\models\Anggota;
// use app\models\Petugas;
// use app\models\Forget;
// use app\models\User;
?>
<div class="row">
	<center>
		<img src="https://lh3.googleusercontent.com/-iEmSMHMxrHs/W9q-3TpA_eI/AAAAAAAAAYg/1xLIu7gkSeQg9pvgg9i6lYwFr8tV8wSlQCJoC/w530-h530-n-rw/nunu.png" style="width: 250px; height: 250px;">
		<hr width="60%">
		<h3>Yang Terhormat,</h3>
		<h1><?= @$model->nama ?></h1>
		<p>Apakah anda yakin ingin merubah password akun perpustakaan anda?</p>
		<p>Jika ingin mengubah password anda silahkan klik tombol dibawah ini.</p>
		<button type="button" style="background: #f6f0f6; border:none; font-size:14px; padding:15px 25px; text-align: center; font-weight: bold; color:#ffffff; font-color: black;">

			<?= Html::a('Reset Password', ['site/new-password', 'token' => @$model->user->token]); ?>
		</button>
		<hr width="60%">
	</center>
</div>