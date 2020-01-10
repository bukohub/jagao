<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ResultadoRevisionProveedor;
use frontend\models\ResultadoRevisionProveedorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ResultadoRevisionProveedorController implements the CRUD actions for ResultadoRevisionProveedor model.
 */
class ResultadoRevisionProveedorController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all ResultadoRevisionProveedor models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ResultadoRevisionProveedorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ResultadoRevisionProveedor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ResultadoRevisionProveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ResultadoRevisionProveedor();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            switch ($model->resultado) {
                case 'Aprobado':
                    $model->estadoAprobado();
                    break;
                /*case 'Devuelto': //Se elimina a petición del cliente
                    $model->estadoDevuelto();
                    break;*/
                case 'Rechazado':
                    $model->estadoRechazado();
                    break;
            }
            Yii::$app->notificador->enviarCorreoResultadoProveedor($model);
            return $this->redirect(['//proveedor/index']);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ResultadoRevisionProveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ResultadoRevisionProveedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ResultadoRevisionProveedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ResultadoRevisionProveedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ResultadoRevisionProveedor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
