<?php
use app\models\User;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (User::isAdmin()): ?>
                           <?= User::getFotoAdmin(['class' => 'img-circle']); ?>
                       <?php endif ?>
                       <?php if (User::isAnggota()): ?>
                           <?= User::getFotoAnggota(['class' => 'img-circle']); ?>
                       <?php endif ?>
            </div>
            <div class="pull-left info">
                <!-- untuk menentukan siapa yg login -->
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?php if (User::isAdmin()){ ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'home', 'url' => ['site/dashboard']],
                    ['label' => 'Data', 'options' => ['class' => 'header']],
                    ['label' => 'Data Peminjaman', 'icon' => 'calendar-o', 'url' => ['peminjaman/index']],
                    ['label' => 'Data Buku', 'icon' => 'book', 'url' => ['buku/index']],
                    ['label' => 'Data Penerbit', 'icon' => 'building', 'url' => ['penerbit/index']],
                    ['label' => 'Data Penulis', 'icon' => 'user', 'url' => ['penulis/index']],
                    ['label' => 'Kategori Buku', 'icon' => 'server', 'url' => ['kategori/index']],
                    ['label' => 'User', 'options' => ['class' => 'header']],
                    ['label' => 'Data Anggota', 'icon' => 'users', 'url' => ['anggota/index']],
                    ['label' => 'Data Petugas', 'icon' => 'user', 'url' => ['petugas/index']],
                    ['label' => 'Data User', 'icon' => 'child', 'url' => ['user/index']],
                ],
            ]
        ) ?>

    <?php } elseif(User::isAnggota()) { ?>
            <?= dmstr\widgets\Menu::widget(
            [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        //['label' => 'Rumah', 'icon' => 'home', 'url' => ['site/index'],],
                        ['label' => 'Home', 'icon' => 'home', 'url' => ['site/dashboard'],],
                        ['label' => 'myLibrary', 'options' => ['class' => 'header']],
                        // ['label' => 'Buku', 'icon' => 'book', 'url' => ['buku/index'],],
                        ['label' => 'Peminjaman', 'icon' => 'calendar-o', 'url' => ['peminjaman/index'],],
                        ['label' => 'Option', 'options' => ['class' => 'header']],
                    ],
            ]
        ) ?>

        
     <?php } elseif(User::isPetugas()) {?>

        <?= dmstr\widgets\Menu::widget(
            [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        //['label' => 'Rumah', 'icon' => 'home', 'url' => ['site/index'],],
                        ['label' => 'Home', 'icon' => 'home', 'url' => ['site/dashboard'],],
                        ['label' => 'Menu Data', 'options' => ['class' => 'header']],
                        ['label' => 'Data Peminjaman', 'icon' => 'calendar-o', 'url' => ['peminjaman/index']],
                        ['label' => 'Data Buku', 'icon' => 'book', 'url' => ['buku/index']],
                        ['label' => 'Data Penerbit', 'icon' => 'building', 'url' => ['penerbit/index']],
                        ['label' => 'Data Penulis', 'icon' => 'user', 'url' => ['penulis/index']],
                        ['label' => 'Kategori Buku', 'icon' => 'server', 'url' => ['kategori/index']],
                        ['label' => 'Menu Pengguna', 'options' => ['class' => 'header']],
                        ['label' => 'Anggota', 'icon' => 'user', 'url' => ['anggota/index'],],
                    ],
            ]
        ) ?>
    <?php } ?>

    </section>

</aside>
