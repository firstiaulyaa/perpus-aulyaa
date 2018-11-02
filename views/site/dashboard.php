 <?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use app\models\Buku;
use app\models\Kategori;
use app\models\Penerbit;
use app\models\Penulis;
use app\models\Anggota;
use app\models\Petugas;
use app\models\User;
use app\models\Peminjaman;
use yii\widgets\LinkPager;
?>

<!-- Dashboard Admin -->
<?php if (Yii::$app->user->identity->id_user_role == 1):
$this->title = 'Dashboard myLibrary'; ?>
<div class="row">

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <p>Jumlah Buku</p>

                <h3><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-book"></i>
            </div>
            <a href="<?=Url::to(['buku/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <p>Jumlah Penulis</p>

                <h3><?= Yii::$app->formatter->asInteger(Penulis::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="<?=Url::to(['penulis/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <p>Jumlah Penerbit</p>

                <h3><?= Yii::$app->formatter->asInteger(Penerbit::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
            <a href="<?=Url::to(['penerbit/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <p>Jumlah Anggota</p>

                <h3><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?=Url::to(['anggota/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
 
<!-- Chart Bar --> 
<div class="row">
    <!-- Grafik Bar -->
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Buku</h3>
            </div>
            <div class="box-body">
                <?=Highcharts::widget([
                    'options' => [
                        'credits' => false,
                        'title' => ['text' => 'KATEGORI BUKU'],
                        'exporting' => ['enabled' => true],
                        'plotOptions' => [
                            'pie' => [
                                'cursor' => 'pointer',
                            ],
                        ],
                        'series' => [
                            [
                                'type' => 'pie', //bar
                                'name' => 'Buku',
                                'data' => Kategori::getGrafikList(),
                            ],
                        ],
                    ],
                ]);?>
            </div>
           </div>
        </div>
    <!-- Akhir Grafik Bar -->

    <!-- Grafik Line -->
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penulis Buku</h3>
                    </div>
                    <div class="box-body">
                        <?=Highcharts::widget([
                            'options' => [
                                'credits' => false,
                                'title' => ['text' => 'PENULIS BUKU'],
                                'exporting' => ['enabled' => true],
                                'plotOptions' => [
                                    'pie' => [
                                        'cursor' => 'pointer',
                                    ],
                                ],
                                'series' => [
                                    [
                                        'type' => 'column', //line //column
                                        'name' => 'Penulis',
                                        'data' => Penulis::getGrafikList(),
                                    ],
                                ],
                            ],
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Grafik Line -->

        <!-- Grafik Pie -->
            <div class="row" style="margin-left: 0px;">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Penerbit Buku</h3>
                        </div>
                        <div class="box-body">
                            <?=Highcharts::widget([
                                'options' => [
                                    'credits' => false,
                                    'title' => ['text' => 'PENERBIT BUKU'],
                                    'exporting' => ['enabled' => true],
                                    'plotOptions' => [
                                        'pie' => [
                                            'cursor' => 'pointer',
                                        ],
                                    ],
                                    'series' => [
                                        [
                                            'type' => 'pie', //column //line
                                            'name' => 'Penerbit',
                                            'data' => Penerbit::getGrafikList(),
                                        ],
                                    ],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>

                <div class="site-index">

                    <div class="row">
                        <div class="col-lg-4">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Akhir Grafik Pie -->
    <?php endif ?>
<!-- Akhir Dashboard Admin -->

<!-- Dashboard Anggota -->
<?php if (Yii::$app->user->identity->id_user_role == 2): ?>
<?php $this->title = 'Selamat datang di myLibrary'; ?>

<div class="row">
    <?php foreach (Buku::find()->all() as $buku) {?> 
        <!-- Kolom box mulai -->
        <div class="col-md-4">
            <!-- Box mulai -->
            <div class="box box-widget">

                <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="<?= Yii::getAlias('@web').'/images/a.png'; ?>" alt="User Image">
                        <span class="username"><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></span>
                        <span class="description">Tahun <?= $buku->tahun_terbit; ?></span>
                    </div>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read"><i class="fa fa-circle-o"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <img style="max-height: 250px; margin-right: auto; margin-left: auto; display: block;"
                     src="<?= Yii::$app->request->baseUrl.'/upload/sampul/'.$buku['sampul']; ?>" alt="Photo">
                    <p>Sinopsis : <?= substr($buku->sinopsis,0,120);?> ...</p>
                    <?= Html::a("Detail Buku",["buku/view","id"=>$buku->id],['class' => 'btn btn-default']) ?>
                    <?= Html::a('Pinjam Buku', ['peminjaman/create', 'id' => $buku->id], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'confirm' => 'Apa anda yakin ingin meminjam buku ini?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <!-- <span class="pull-right text-muted">127 Peminjam - 3 Komentar</span> -->
                </div>

                <div class="row">
                    <center>
                      <?= LinkPager::widget([
                        'pagination' => $provider->pagination,
                      ]); ?>
                    </center>
                </div>
            </div>
            <!-- Box selesai -->
        </div>
        <!-- Kolom box selesai -->  
    <?php
        }
    ?>

</div>
<?php endif ?>
<!-- Akhir Dashboard Anggota -->

<!-- Dashboard Petugas -->
<?php if (Yii::$app->user->identity->id_user_role == 3): ?>
<?php $this->title = 'Selamat Datang di MyLibrary'; ?>

<div class="row">

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <p>Jumlah Buku</p>

                <h3><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-book"></i>
            </div>
            <a href="<?=Url::to(['buku/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <p>Jumlah Penulis</p>

                <h3><?= Yii::$app->formatter->asInteger(Penulis::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="<?=Url::to(['penulis/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <p>Jumlah Penerbit</p>

                <h3><?= Yii::$app->formatter->asInteger(Penerbit::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
            <a href="<?=Url::to(['penerbit/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <p>Jumlah Anggota</p>

                <h3><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?=Url::to(['anggota/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
 
<!-- Chart Bar --> 
<div class="row">
    <!-- Grafik Bar -->
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kategori Buku</h3>
            </div>
            <div class="box-body">
                <?=Highcharts::widget([
                    'options' => [
                        'credits' => false,
                        'title' => ['text' => 'KATEGORI BUKU'],
                        'exporting' => ['enabled' => true],
                        'plotOptions' => [
                            'pie' => [
                                'cursor' => 'pointer',
                            ],
                        ],
                        'series' => [
                            [
                                'type' => 'pie', //bar
                                'name' => 'Buku',
                                'data' => Kategori::getGrafikList(),
                            ],
                        ],
                    ],
                ]);?>
            </div>
           </div>
        </div>
    <!-- Akhir Grafik Bar -->

    <!-- Grafik Line -->
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penulis Buku</h3>
                    </div>
                    <div class="box-body">
                        <?=Highcharts::widget([
                            'options' => [
                                'credits' => false,
                                'title' => ['text' => 'PENULIS BUKU'],
                                'exporting' => ['enabled' => true],
                                'plotOptions' => [
                                    'pie' => [
                                        'cursor' => 'pointer',
                                    ],
                                ],
                                'series' => [
                                    [
                                        'type' => 'pie', //line //column
                                        'name' => 'Penulis',
                                        'data' => Penulis::getGrafikList(),
                                    ],
                                ],
                            ],
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Grafik Line -->

        <!-- Grafik Pie -->
            <div class="row" style="margin-left: 0px;">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Penerbit Buku</h3>
                        </div>
                        <div class="box-body">
                            <?=Highcharts::widget([
                                'options' => [
                                    'credits' => false,
                                    'title' => ['text' => 'PENERBIT BUKU'],
                                    'exporting' => ['enabled' => true],
                                    'plotOptions' => [
                                        'pie' => [
                                            'cursor' => 'pointer',
                                        ],
                                    ],
                                    'series' => [
                                        [
                                            'type' => 'pie', //column //line
                                            'name' => 'Penerbit',
                                            'data' => Penerbit::getGrafikList(),
                                        ],
                                    ],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>

                <div class="site-index">

                    <div class="row">
                        <div class="col-lg-4">

                        </div>
                    </div>

                </div>
            </div>
        </div>
  <!-- Akhir Grafik Pie -->
</div>
</div>
<?php endif ?>
<!-- Akhir Dashboard Petugas -->