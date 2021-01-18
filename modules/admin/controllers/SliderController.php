<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\SliderImage;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SliderController implements the CRUD actions for SliderImage model.
 */
class SliderController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all SliderImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $images = SliderImage::find()->all();
        return $this->render('index', ['images'=>$images]);
    }

    /**
     * Displays a single SliderImage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SliderImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SliderImage();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {

                return $this->redirect(['view', 'id' => $model->id]);

            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SliderImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->validate()) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {

                return $this->redirect(['view', 'id' => $model->id]);

            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SliderImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
            $model = $this->findModel($id);
            $imgName = $model->img_url;
            unlink(Yii::getAlias('').$imgName);
            $model->delete();

            return $this->redirect(['index']);
    }

    /**
     * Finds the SliderImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SliderImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SliderImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
