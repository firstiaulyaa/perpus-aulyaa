<?php
use yii\helpers\Html;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">myL</span><span class="logo-lg">myLibrary</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <?php if (User::isAdmin()): ?>
                         <?= User::getFotoAdmin(['class' => 'user-image']); ?>
                     <?php endif ?>
                     <?php if (User::isAnggota()): ?>
                         <?= User::getFotoAnggota(['class' => 'user-image']); ?>
                     <?php endif ?>
                     <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" >
                            <?php if (User::isAdmin()): ?>
                                <?= User::getFotoAdmin(['class' => 'img-circle']); ?>
                            <?php endif ?>
                            <?php if (User::isAnggota()): ?>
                                <?= User::getFotoAnggota(['class' => 'img-circle']); ?>
                            <?php endif ?>
                            <p>
                                <?= Yii::$app->user->identity->username ?>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                     <?php if (User::isAnggota()): ?>
                         <?= Html::a(
                            'Profile',
                            ['anggota/update', 'id' => Yii::$app->user->identity->id_anggota],
                            ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                        ) ?>
                    <?php endif ?>
                    <?php if (User::isPetugas()): ?>
                     <?= Html::a(
                        'Profile',
                        ['petugas/update', 'id' => Yii::$app->user->identity->id_petugas],
                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                    ) ?>
                <?php endif ?>

            </div>
            <div class="pull-right">
                <?= Html::a(
                    'Sign out',
                    ['site/logout'],
                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                ) ?>
            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
