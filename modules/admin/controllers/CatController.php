<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Color;
use app\modules\admin\models\Title;
use app\modules\admin\models\Cat;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class CatController extends DefaultController
{

    /**
     * Lists all Cat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cat::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cat model.
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
     * Creates a new Cat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cat = new Cat();
        $colors = Color::find()
            ->select(['name'])
            ->indexBy('id')
            ->column();
        $titles = Title::find()
            ->select(['description'])
            ->indexBy('id')
            ->column();

        if ($cat->load(Yii::$app->request->post()) && $cat->save()) {
            return $this->redirect(['view', 'id' => $cat->id]);
        } else {
            return $this->render('create', [
                'cat' => $cat,
                'colors' => $colors,
                'titles' => $titles
            ]);
        }
    }

    /**
     * Updates an existing Cat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $cat = $this->findModel($id);
        $colors = Color::find()
            ->select(['name'])
            ->indexBy('id')
            ->column();
        $titles = Title::find()
            ->select(['description'])
            ->indexBy('id')
            ->column();

        if ($cat->load(Yii::$app->request->post()) && $cat->save()) {
            return $this->redirect(['view', 'id' => $cat->id]);
        } else {
            return $this->render('update', [
                'cat' => $cat,
                'colors' => $colors,
                'titles' => $titles
            ]);
        }
    }

    /**
     * Deletes an existing Cat model.
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
     * Finds the Cat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
