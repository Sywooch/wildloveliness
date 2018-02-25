<?php

namespace app\modules\admin\controllers;

use app\helpers\DevHelper;
use Yii;
use app\modules\admin\models\Pet;
use app\modules\admin\models\PetSearch;
use app\modules\admin\models\Color;
use app\modules\admin\models\Title;
use app\modules\admin\models\Litter;
use app\modules\admin\models\Status;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * PetController implements the CRUD actions for Pet model.
 */
class PetController extends DefaultController
{

    /**
     * Lists all Pet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    /**
     * Creates a new Pet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $pet = new Pet();
        $colors = Color::find()->select(['name'])->indexBy('id')->column();
        $titles = Title::find()->select(['description'])->indexBy('id')->column();
        $litters = Litter::find()->select(['charcode'])->indexBy('id')->column();
        $statuses = Status::find()->select(['title'])->indexBy('id')->column();

        if ($pet->load(Yii::$app->request->post()) && $pet->save()) {
            return $this->redirect(['index', 'id' => $pet->id]);
        }

        return $this->render('create', compact('pet', 'colors','titles','litters', 'statuses'));
    }

    /**
     * Updates an existing Pet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $pet = $this->findModel($id);
        $colors = Color::find()->select(['name'])->indexBy('id')->column();
        $titles = Title::find()->select(['description'])->indexBy('id')->column();
        $litters = Litter::find()->select(['charcode'])->indexBy('id')->column();
        $statuses = Status::find()->select(['title'])->indexBy('id')->column();

        //DevHelper::preArray($pet,1);

        if ($pet->load(Yii::$app->request->post()) && $pet->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', compact('pet', 'colors','titles','litters', 'statuses'));
    }

    /**
     * Deletes an existing Pet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);

//        PJAX
//        $this->findModel($id)->delete();
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => Pet::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Finds the Pet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('forms', 'The requested page does not exist.'));
    }
}
