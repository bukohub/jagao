<?php

namespace frontend\controllers;

use frontend\models\Producto;
use frontend\models\ProductoSubcategoria;
use Yii;
use frontend\models\Subcategoria;
use frontend\models\SubcategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubcategoriaController implements the CRUD actions for Subcategoria model.
 */
class SubcategoriaController extends Controller
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
     * Lists all Subcategoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubcategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subcategoria model.
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
     * Creates a new Subcategoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subcategoria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subcategoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->estado  != 'Activo') {
                $this->switchingStatus($id,7,1);
            } else {
                $this->switchingStatus($id,1,7);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function switchingStatus($id, $estado_nuevo, $estado_viejo)
    {
        $get_prod_sub = ProductoSubcategoria::find()->where(['subcategoria_id' => $id])->all();
        if (!empty($get_prod_sub)) {
            foreach ($get_prod_sub as $sub) {
                $get_producto = Producto::find()->where(['id' => $sub->producto_id, 'estado_producto_id' => $estado_viejo])->one();
                if (!empty($get_producto)) {
                    $get_producto->estado_producto_id =  $estado_nuevo;
                    $get_producto->save();
                }
            }
        }
    }

    /**
     * Deletes an existing Subcategoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Subcategoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Subcategoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subcategoria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
