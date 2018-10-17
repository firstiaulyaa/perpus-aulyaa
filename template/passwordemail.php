<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="row">
<center>
<img src="https://scontent-sit4-1.xx.fbcdn.net/v/t1.0-9/43527301_335953880493708_2071501334321823744_n.jpg?_nc_cat=103&oh=880bb10c3627cb83ae004c12d8db9d8a&oe=5C586B0E" style="width: 250px; height: 250px;">
<hr width="60%">
<h3>Yang Terhormat.</h3>
<h1><?= $model->nama ?></h1>
<p>Apa anda yakin ingin merubah password akun perpus anda ??</p>
<p>Jika ingin ubah password anda silahkan klik tombol dibawah ini.</p>
<button style="padding: 20px; background-color: aqua; color: white; font-size: 20px; border: none; border-radius: 5px;">
<?= Html::a('New Password', ['site/new_password', 'token' => $model->user->token]);?>
</button>
<hr width="60%">
</center>
</div>