<?php

namespace app\modules\admin\controllers;

class FacebookController extends \app\modules\admin\controllers\DefaultController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
