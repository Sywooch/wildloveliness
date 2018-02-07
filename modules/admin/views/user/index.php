<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('forms', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('forms', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',


            // USER ROLE
            [
                'label' => Yii::t('forms', 'Role'),
                'value' => function ($data) {
                    $auth = Yii::$app->authManager;
                    $roleName = $auth->getRole(reset($auth->getAssignments($data->id))->roleName)->description;
                    $userPermissions = $data->getUserPermissions($data->id);
                    $userTooltipText = '<strong>'.$roleName.' может:</strong>';
                    foreach ($userPermissions as $p) {
                        $userTooltipText .= '<br>' . $p->description;
                    }
                    $role = $roleName .
                        ' ' . Html::tag('span', '?', [
                            'class' => 'label label-default',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'data-html' => 'true',
                            'title' => $userTooltipText,
                        ]);
                    return $role;
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'id', // поле в модели, для которого применяется сортировка
                    ArrayHelper::map(ArrayHelper::toArray(Yii::$app->authManager->getRoles()), 'name', 'description'),
                    ['class' => 'form-control', 'prompt'=>Yii::t('forms', 'Select role')]
                )

            ],

            //'password_reset_token',
            'email:email',

            // USER STATUS
            [
                'label' => Yii::t('forms', 'Status'),
                'value' => function ($data) {
                    $statuses = \app\models\User::getAllStatuses();
                    if($data->status)
                        return Html::tag('span', $statuses[$data->status], ['class' => 'label label-success']);
                    else
                        return Html::tag('span', $statuses[$data->status], ['class' => 'label label-danger']);
                },
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status', // поле в модели, для которого применяется сортировка
                    [0=>'Удален',10=>'Активен'],
                    ['class' => 'form-control', 'prompt' => 'Выберите статус']
                )
            ],


            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $index) {
                        return Html::a('<span class="glyphicon glyphicon-pencil btn btn-default btn-xs"></span>',
                            $url, [
                                'title' => \Yii::t('yii', 'Update')
                            ]);
                    },
                    'delete' => function ($url, $model, $index) {
                        if (!$model->status) {
                            return '';
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-trash btn btn-default btn-xs"></span>',
                                $url, [
                                    'title' => \Yii::t('yii', 'Delete'),
                                    'data-confirm' => \Yii::t('forms', 'Are you sure you want to delete this user?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '1',
                                ]);
                        }
                    }
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
