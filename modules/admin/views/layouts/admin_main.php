<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use app\assets\AppAsset;
use app\assets\BackendAsset;
use app\modules\filemanager\assets\FilemanagerAsset;

AppAsset::register($this);
BackendAsset::register($this);
$filemngrAsset = FilemanagerAsset::register($this);
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
        //['label' => 'Админка', 'url' => ['/admin']],
        [
            'label' => 'Справочники',
            'items' => [
                ['label' => 'Питомцы', 'url' => \yii\helpers\Url::to(['/admin/pet'])],
                ['label' => 'Пометы', 'url' => \yii\helpers\Url::to(['/admin/litter'])],
                '<li role="separator" class="divider"></li>',
                ['label' => 'Статусы', 'url' => \yii\helpers\Url::to(['/admin/status'])],
                ['label' => 'Окрасы', 'url' => \yii\helpers\Url::to(['/admin/color'])],
                ['label' => 'Титулы WCF', 'url' => \yii\helpers\Url::to(['/admin/title'])],
                ['label' => 'Пользователи', 'url' => \yii\helpers\Url::to(['/admin/user'])],
                '<li role="separator" class="divider"></li>',
                [
                    'label' => Html::img($filemngrAsset->baseUrl.'/imgs/folder.svg' ) . ' Файловый менеджер',
                    'url' => '#',
                    'options' =>
                    [
                        'class'=>'filemngrToggleBtn',
                        'data-target' => "#roxyMainModal",
                        'data-toggle' => 'modal'
                    ]
                ],
            ],
        ],
        [
            'label' => Html::img($filemngrAsset->baseUrl.'/imgs/folder.svg', ['title'=>'Файловый менеджер',]) . ' Файловый менеджер',
            'options' =>
                [
                    'class'=>'filemngrToggleBtn',
                    'data-target' => "#roxyMainModal",
                    'data-toggle' => 'modal'
                ]
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
        'encodeLabels' => false,
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

        <!-- FILEMANAGER MODALS -->
        <?=$this->renderAjax('@app/modules/filemanager/views/default/index.php');?>


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
