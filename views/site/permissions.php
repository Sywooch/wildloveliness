<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\helpers\DevHelper;

$this->title = 'Users permissions';
$this->params['breadcrumbs'][] = $this->title;
//css
$this->registerCss('
    .allowed-permission {
        color: green;
    }
    .forbidden-permission {
        color: red;
    }
');
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>



    <?php foreach ($users as $user) : ?>
        <div class="col-md-4">
            <h2><?= ucfirst($user->username). " Permissions:"; ?></h2>

            <?php foreach ($permissions as $permission) :?>
                <p>
                    <?php
                    echo $permission->name. ' permission: ';
                    if(Yii::$app->authManager->checkAccess($user->id, $permission->name))
                        echo '<span class="allowed-permission">YES</span>';
                    else
                        echo '<span class="forbidden-permission">NO</span>';
                    ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>




</div>
