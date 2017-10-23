<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Kitten;
use app\modules\admin\models\Color;
use app\modules\admin\models\Litter;
use app\modules\admin\models\Status;
use app\modules\admin\models\Title;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class KittenController extends DefaultController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Kitten models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Kitten::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kitten model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kitten model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $kitten = new Kitten();
        $colors = Color::find()
            ->select(['name'])
            ->indexBy('id')
            ->column();
        $titles = Title::find()
            ->select(['description'])
            ->indexBy('id')
            ->column();
        $litters = Litter::find()
            ->select(['charcode'])
            ->indexBy('id')
            ->column();
        $statuses = Status::find()
            ->select(['title'])
            ->indexBy('id')
            ->column();

        if ($kitten->load(Yii::$app->request->post()) && $kitten->save()) {
            return $this->redirect(['view', 'id' => $kitten->id]);
        } else {
            return $this->render('create', [
                'kitten' => $kitten,
                'colors' => $colors,
                'titles' => $titles,
                'litters' => $litters,
                'statuses' => $statuses
            ]);
        }
    }

    /**
     * Updates an existing Kitten model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $kitten = $this->findModel($id);
        $colors = Color::find()
            ->select(['name'])
            ->indexBy('id')
            ->column();
        $titles = Title::find()
            ->select(['description'])
            ->indexBy('id')
            ->column();
        $litters = Litter::find()
            ->select(['charcode'])
            ->indexBy('id')
            ->column();
        $statuses = Status::find()
            ->select(['title'])
            ->indexBy('id')
            ->column();

        if ($kitten->load(Yii::$app->request->post()) && $kitten->save()) {
            return $this->redirect(['view', 'id' => $kitten->id]);
        } else {
            return $this->render('update', [
                'kitten' => $kitten,
                'colors' => $colors,
                'titles' => $titles,
                'litters' => $litters,
                'statuses' => $statuses
            ]);
        }
    }

    /**
     * Deletes an existing Kitten model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kitten model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kitten the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kitten::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
