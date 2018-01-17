<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Pet;
use app\modules\admin\models\Litter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * LitterController implements the CRUD actions for Litter model.
 */
class LitterController extends DefaultController
{

    /**
     * Lists all Litter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Litter::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Litter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $litter = new Litter();
        $father = Pet::find()
            ->select(['name'])
            ->indexBy('id')
            ->where(['gender' => 'm'])
            ->andWhere(['status_id' => 4])
            ->column();
        $mother = Pet::find()
            ->select(['name'])
            ->indexBy('id')
            ->where(['gender' => 'f'])
            ->andWhere(['status_id' => 4])
            ->column();

        if ($litter->load(Yii::$app->request->post()) && $litter->save()) {
            return $this->redirect(['index', 'id' => $litter->id]);
        } else {
            return $this->render('create', [
                'litter' => $litter,
                'father' => $father,
                'mother' => $mother
            ]);
        }
    }

    /**
     * Updates an existing Litter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $litter = $this->findModel($id);
        $father = Pet::find()
            ->select(['name'])
            ->indexBy('id')
            ->where(['gender' => 'm'])
            ->andWhere(['status_id' => 4])
            ->column();
        $mother = Pet::find()
            ->select(['name'])
            ->indexBy('id')
            ->where(['gender' => 'f'])
            ->andWhere(['status_id' => 4])
            ->column();

        if ($litter->load(Yii::$app->request->post()) && $litter->save()) {
            return $this->redirect(['index', 'id' => $litter->id]);
        } else {
            return $this->render('update', [
                'litter' => $litter,
                'father' => $father,
                'mother' => $mother
            ]);
        }
    }

    /**
     * Deletes an existing Litter model.
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
     * Finds the Litter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Litter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Litter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
