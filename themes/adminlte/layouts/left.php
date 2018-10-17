<?php
use app\models\User;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/> -->
                <img src="<?= Yii::getAlias('@web').'/images/a.png'; ?>" class="img-circle" alt="User Image"/>
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
        <!-- mengecek login -->
        <?php if (User::isAdmin()) { ?>
            <?= dmstr\Widgets\Menu::widget (
            ) ?>
        <?php } elseif (User::isAnggota()) { ?>
            
        <?= dmstr\Widgets\Menu::widget(
        ) ?> 
        <?php } ?>

        <!-- Navigasi Admin -->
        <?php if (Yii::$app->user->identity->id_user_role == 1): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
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
                    ['label' => 'Option', 'options' => ['class' => 'header']],
                    ['label' => 'Logout', 'icon' => 'sign-out', 'url' => ['#']], 
                ],
            ]
        ) ?>
    <?php endif ?>
    <!-- mengecek login -->
        <?php if (User::isAnggota()) { ?>
            <?= dmstr\Widgets\Menu::widget (
            ) ?>
        <?php } elseif (User::isPetugas()) { ?>
            
        <?= dmstr\Widgets\Menu::widget(
        ) ?> 
        <?php } ?>
     <!-- Navigasi Anggota -->
    <?php if (Yii::$app->user->identity->id_user_role == 2): ?>
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
                        ['label' => 'Logout', 'icon' => 'sign-out', 'url' => ['#']], 
                    ],
            ]
        ) ?>
    <?php endif ?>
    <!-- mengecek login -->
        <?php if (User::isPetugas()) { ?>
            <?= dmstr\Widgets\Menu::widget (
            ) ?>
        <?php } elseif (User::isAdmin()) { ?>
            
        <?= dmstr\Widgets\Menu::widget(
        ) ?> 
        <?php } ?>
    <!-- Navigasi Petugas -->
    <?php if (Yii::$app->user->identity->id_user_role == 3): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        //['label' => 'Rumah', 'icon' => 'home', 'url' => ['site/index'],],
                        ['label' => 'Home', 'icon' => 'home', 'url' => ['site/dashboard'],],
                        ['label' => 'Menu Buku', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Buku',
                            'icon' => 'book',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Buku', 'icon' => 'book', 'url' => ['buku/index'],],
                                ['label' => 'Kategori', 'icon' => 'server', 'url' => ['kategori/index'],],
                                ['label' => 'Penerbit', 'icon' => 'building', 'url' => ['penerbit/index'],],
                                ['label' => 'Penulis', 'icon' => 'user', 'url' => ['penulis/index'],],
                                ['label' => 'Peminjaman', 'icon' => 'calendar-o', 'url' => ['peminjaman/index'],],
                            ],
                        ],
                        ['label' => 'Menu Pengguna', 'options' => ['class' => 'header']],
                        ['label' => 'Anggota', 'icon' => 'user', 'url' => ['anggota/index'],],
                        ['label' => 'Option', 'options' => ['class' => 'header']],
                    ['label' => 'Logout', 'icon' => 'sign-out', 'url' => ['#']], 
                        
                    ],
            ]
        ) ?>
    <?php endif ?>

    </section>

</aside>
