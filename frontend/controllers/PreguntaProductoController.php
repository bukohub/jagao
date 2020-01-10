<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PreguntaProducto;
use frontend\models\PreguntaProductoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PreguntaProductoController implements the CRUD actions for PreguntaProducto model.
 */
class PreguntaProductoController extends Controller
{
    
    public $layout = 'main-admin';
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
     * Lists all PreguntaProducto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreguntaProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title        = 'Preguntas de mis Productos';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>$title,
            'button'=>false
        ]);
    }
    public function actionMe(){
        $searchModel = new PreguntaProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, FALSE);
        $title        = 'Mis Preguntas';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>$title,
            'button'=>true
        ]);
    }

    /**
     * Displays a single PreguntaProducto model.
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
     * Creates a new PreguntaProducto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PreguntaProducto();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->notificador->enviarCorreoNuevaPregunta($model);
            return $this->redirect(['producto/detalle-producto', 'idProducto' => $model->producto_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PreguntaProducto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PreguntaProducto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PreguntaProducto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PreguntaProducto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PreguntaProducto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
