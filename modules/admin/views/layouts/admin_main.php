<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Wild loveliness ADMIN PANEL',
        'brandUrl' => \yii\helpers\Url::to(['/admin']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Админка', 'url' => ['/admin']],

        '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#roxyMainModal">Файловый менеджер</button>',

        [
            'label' => 'Справочники',
            'items' => [
                ['label' => 'Статусы котят', 'url' => '/admin/status'],
                ['label' => 'Окрасы кошек', 'url' => '/admin/color'],
                ['label' => 'Титулы WCF', 'url' => '/admin/title'],
            ],
        ],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('adminPages', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => 'Панель управления',
                'url' => '/admin',
                'class' => 'external',
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>





        <?=$this->renderAjax('@app/modules/filemanager/views/default/index.php');?>

        <!-- ROXY MODAL -->
<!--        -->
<!--        <div class="modal fade" id="roxyMainModal" tabindex="-1" role="dialog" aria-labelledby="roxyModalLabel">-->
<!--            <div class="modal-dialog" style="width:97%;"  role="document">-->
<!--                <div class="modal-content">-->
<!--                    <div class="modal-header">-->
<!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                        <h4 class="modal-title" id="roxyModalLabel">Файловый менеджер</h4>-->
<!--                    </div>-->
<!--                    <div class="modal-body">-->
<!--                        -->
<!--                    </div>-->
<!--                    <div class="modal-footer">-->
<!--                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>-->
<!--                        <button type="button" class="btn btn-primary">Сохранить</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        -->




    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Wild loveliness <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>













<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
