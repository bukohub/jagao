<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProductoCompras;
use frontend\models\ProductoComprasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoComprasController implements the CRUD actions for ProductoCompras model.
 */
class ProductoComprasController extends Controller
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
     * Lists all ProductoCompras models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoComprasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all ProductoCompras models.
     * @return mixed
     */
    public function actionMisCompras()
    {
        $searchModel = new ProductoComprasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, FALSE);

        return $this->render('mis_compras', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single ProductoCompras model.
     * @param string $id
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
     * Updates an existing ProductoCompras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('r-proveedor') or Yii::$app->user->can('r-administrador-jagao')){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->almacenarSeguimiento($model, Yii::$app->request->post()['ProductoCompras']['numero_guia']);
            return $this->redirect(['view', 'id' => $model->id]);         
        }
        return $this->render('update', [
            'model' => $model,
        ]);
        }
    }
     /**
     * Actualiza para pagos a proveedor
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPagoProveedor($id,$pay) {      
        if (Yii::$app->user->can('r-administrador-jagao')) {
            $model = $this->findModel($id);
            $model->pago_proveedor = $pay;
            $model->save();           
        }
        return $this->redirect(['index']); 
    }


    /**
     * Deletes an existing ProductoCompras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Finds the ProductoCompras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductoCompras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductoCompras::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
