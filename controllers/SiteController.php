<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\validators\DateValidator;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\helpers\DevHelper;
use app\models\User;
use app\models\SignupForm;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends AppController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //echo('<br><br><br><br><br><br><br><br><br><br><br><br>');


//        DevHelper::preArray(Yii::$app->user->isGuest);
//        if(!Yii::$app->user->isGuest){
//            DevHelper::preArray(Yii::$app->user->identity->isRegistereduser());
//        }



        $allRolesArr = ArrayHelper::toArray(Yii::$app->authManager->getRoles());
        $allRolesArr = ArrayHelper::map($allRolesArr, 'name', 'description');

        //DevHelper::preArray($allRolesArr);



        //DevHelper::preArray($allRolesArr);


        //DevHelper::preArray(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)); // роли, приписанные к текущему пользователю
        //DevHelper::preArray(Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id)); // разрешения для текущего пользователя
        //DevHelper::preArray(Yii::$app->authManager->getAssignments(Yii::$app->user->id));
        //DevHelper::preArray(Yii::$app->authManager->getPermissions());// все разрешения в системе
        //DevHelper::preArray(Yii::$app->authManager->getRoles()); // все роли в системе


        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionCheck()
    {
        $users = User::find()->orderBy('id desc')->all();
        $permissions = Yii::$app->authManager->getPermissions();

        $guestUser = new User();
        $guestUser->username = 'guest';

        return $this->render('permissions', [
            'users' => $users,
            'users' => ArrayHelper::merge([$guestUser], $users),
            'permissions' => $permissions,
        ]);
    }

}
