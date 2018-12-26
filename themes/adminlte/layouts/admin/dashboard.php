<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Anggota;
use app\models\Petugas;
use app\models\Buku;
use app\models\Peminjaman;
use app\models\Penerbit;
use app\models\Kategori;
use app\models\Penulis;
use miloschuman\highcharts\Highcharts;
use app\models\User;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = 'myLibrary';
?>

<!-- Dashboard Admin -->
<?php if (Yii::$app->user->identity->id_user_role == 1): ?>

  <!-- Jumlah Data -->
  <!-- Menampilkan jumlah Anggota -->
  <div class="site-index">
    <div class="row" style="margin: 3px;">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <p>Jumlah Anggota</p>

            <h3><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></h3>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <a href="<?=Url::to(['anggota/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Menampilkan jumlah Petugas -->
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
          <div class="inner">
            <p>Jumlah Petugas</p>

            <h3><?= Yii::$app->formatter->asInteger(Petugas::getCount()); ?></h3>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="<?=Url::to(['petugas/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Menampilkan jumlah User -->
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
          <div class="inner">
            <p>Jumlah User</p>

            <h3><?= Yii::$app->formatter->asInteger(Kategori::getCount()); ?></h3>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="<?=Url::to(['user/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Menampilkan jumlah Penulis -->
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
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

  <!-- Menampilkan jumlah Penerbit -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(Penerbit::getCount()); ?></h3>
            <p>Jumlah Penerbit</p>
          </div>
          <div class="icon">
            <i class="fa fa-bookmark"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Menampilkan jumlah Buku -->
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
          <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></h3>
            <p>Jumlah Buku</p>
          </div>
          <div class="icon">
            <i class="fa fa-book"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Menampilkan jumlah peminjam -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(Peminjaman::getCount()); ?></h3>
            <p>Jumlah Peminjam</p>
          </div>
          <div class="icon">
            <i class="fa fa-exchange"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

  <!-- Grafik -->
  <!-- Grafik Kategori Buku -->
  <div class="row">
    <div class="col-sm-6">
      <div class="box box-primary">
      <div class="box-header with-border">
          <h3 class="box-title">Buku Berdasarkan Kategori</h3>
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
              'type' => 'pie',
              'name' => 'Kategori',
              'data' => Kategori::getGrafikList(),
            ],
          ],
          ],
          ]);?>
        </div>
      </div>
    </div>

  <!-- Grafik Penulis -->
  <div class="col-sm-6">
    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Buku Berdasarkan Penulis</h3>
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
              'type' => 'line',
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

  <div class="col-sm-14">
    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Peminjam Terbaru</h3>
    </div>
      <div class="box-body">
    
      <table class="table table-bordered table-hover">
            <thead class="bg-purple">
          <tr>
            <th width="55px" class="text-center" rowspan="2">No</th>
            <th class="text-center" rowspan="2">Nama Buku</th>
            <th class="text-center" rowspan="2">Nama Peminjam</th>
            <th class="text-center" colspan="5">Tanggal Pengembalian</th>
            <th class="text-center" rowspan="2">   </th>
          </tr>
          <tr>
            <th width="150px" class="text-center">Tanggal Pinjam</th>
            <th width="150px" class="text-center">Batas Kembali</th>
            <th width="150px" class="text-center">Pengembalian</th>
            <th width="150px" class="text-center">Status</th>
            <th width="150px" class="text-center">Selisih Hari</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; ?>
          <?php foreach (Peminjaman::find()->andWhere(['status_buku' => 1])->orderBy(['tanggal_pinjam' => SORT_DESC])->limit(10)->all() as $peminjaman): ?>
            
          <tr>
            <td class="text-center"><?= $no; ?></td>
            <td><?= $peminjaman->buku->nama ?></td>
            <td><?= $peminjaman->anggota->nama ?></td>
            <td><center><?= $peminjaman->tanggal_pinjam ?></center></td>
            <td><center><?= $peminjaman->tanggal_kembali ?></center></td>
            <td><center><?= $peminjaman->tanggal_pengembalian_buku ?></center></td>
            <td><center><?= $peminjaman->getStatusPeminjaman() ?></center></td>
            <td><center><?= $peminjaman->getTanggal() ?></center></td>
            <td> <?= Html::a('Detail', ['peminjaman/view', 'id' => $peminjaman->id], ['class' => 'btn btn-primary']); ?></td>
            <td class="text-center">
              <?= Html::a('<i class="fa fa-check-square-o"></i>', $url = null, ['data-toggle' => 'tooltip', 'title' => 'Setujui Buku','data-confirm' => 'Apakah anda yakin akan menyetujui buku yang di pinjam?']); ?>
            </td>
          </tr>
          <?php $no++ ?> 
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php endif ?>
<!-- Akhir Dashboard Admin -->



<!-- Dashboard Anggota -->
<?php $this->title = 'myLibrary'; ?>
<?php if (Yii::$app->user->identity->id_user_role == 2): ?>

  <div class="row">

    <?php foreach ($provider->getModels() as $buku) {?> 
      <div class="col-md-4">
        <div class="box box-widget">
          <div class="box-header with-border">
            <div class="user-block">
              <span class="username"><?= Html::a($buku->nama, ['buku/view', 'id' => $buku->id]); ?></span>
              <span class="description"> Tahun Terbit : <?= $buku->tahun_terbit; ?></span>
            </div>
            <div class="box-tools">
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read"><i class="fa fa-circle-o"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">
            <img class="img-responsive pad" style="height: 300px;" src="<?= Yii::$app->request->baseUrl.'/upload/sampul/'.$buku['sampul']; ?>" alt="Photo">
            <p>Sinopsis : <?= substr($buku->sinopsis,0,40);?> ...</p>
            <?= Html::a('Detail Buku', ['buku/view' , 'id' => $buku->id], ['class' => 'btn btn-default']) ?>
            <?= Html::a('Pinjam Buku', ['peminjaman/create', 'id_buku' => $buku->id], [
              'class' => 'btn btn-success',
              'data' => [
                'confirm' => 'Apa anda yakin ingin meminjam buku ini?',
                'method' => 'post',
              ],
            ]) ?>
          </div>
        </div>
      </div>
      <?php
    }
    ?>
  </div>

  <div class="row">
    <center>
      <?= LinkPager::widget([
        'pagination' => $provider->pagination,
      ]); ?>
    </center>
  </div>
<?php endif ?>
<!-- Akhir Dashboard Anggota -->



