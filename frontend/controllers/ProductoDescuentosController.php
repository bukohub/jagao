<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProductoDescuentos;
use frontend\models\ProductoDescuentosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoDescuentosController implements the CRUD actions for ProductoDescuentos model.
 */
class ProductoDescuentosController extends Controller
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
     * Lists all ProductoDescuentos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoDescuentosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductoDescuentos model.
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
     * Creates a new ProductoDescuentos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('r-proveedor')){

        $model = new ProductoDescuentos();

        if ($model->load(Yii::$app->request->post()) ) {
            $request = Yii::$app->request;
            $model->producto_id = $request->post()['ProductoDescuentos']['producto_id'];
            $model->descuento   = $request->post()['ProductoDescuentos']['descuento'];
            if(!$model->save()){
                return $this->render('//site/error', [
                    'name' => 'Error en la creación de Descuento',
                    'message' => 'Por favor, valide que este producto no tenga un descuento existente.',
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
        }
    }

    /**
     * Updates an existing ProductoDescuentos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('r-proveedor')){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        }
    }

    /**
     * Deletes an existing ProductoDescuentos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('r-proveedor')){
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }
    }

    /**
     * Finds the ProductoDescuentos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductoDescuentos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductoDescuentos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
