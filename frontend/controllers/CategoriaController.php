<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Categoria;
use frontend\models\Producto;
use frontend\models\CategoriaSearch;
use frontend\models\ProductoCategoria;
use frontend\models\ProductoSubcategoria;
use frontend\models\Proveedor;
use frontend\models\Subcategoria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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
     * Lists all Categoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
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
     * Método que muestra el detalle de una categoria (productos)
     * @param mixed[] $categoria Array, nombre de la categoría
     * @param integer $id, si no es nulo significa que es categoría principal
     * @param integer $sub, si no es nulo significa que es categoría secundaria
     * @author Michael Rosero
     */
    public function actionCategoriaDetalle($id = NULL, $sub = NULL, $categoria = NULL)
    {

        $this->layout = 'main';
        $request      = Yii::$app->request;
        $proveedor    = ArrayHelper::getValue($request->get(), 'proveedor');

        /**
         * Obtengo filtros para el máximo valor y el mínimo
         */
        $filterMin  = $request->get('minimo');
        $filterMax  = $request->get('maximo');

        /**
         * Obtengo los productos relacionadas a las categorías
         */
        $query      = ProductoSubcategoria::find()->select('b.precio_pesos,producto_subcategoria.producto_id')->joinWith(["producto b"], true, 'INNER JOIN')->joinWith(["subcategoria c"], true, 'INNER JOIN')->where(['=', 'b.estado_producto_id', 1])->andWhere(['c.estado' => 'Activo']);
        $get_prov   = Proveedor::find()->where(['estado_id' => 1])->all();

        /**
         * Consulta según los parámetros
         */
        if (!empty($id))
            $query  = $query->andWhere(['c.categoria_id' => $id]);

        if (!empty($sub))
            $query  = $query->andWhere(['subcategoria_id' => $sub]);

        if (!empty($filterMin) and !empty($filterMax))
            $query  = $query->andWhere(['between', 'b.precio_pesos', $filterMin, $filterMax]);

        if (!empty($proveedor))
            $query  = $query->andWhere(['b.proveedor_id' => array_values($proveedor)]);

        if (empty($query))
            $query  = ProductoCategoria::find()->joinWith(["producto b"], true, 'INNER JOIN')->where(['=', 'b.estado_producto_id', 1]);

        /** Paginador */
        $pages      = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 9]);
        $producto_categoria    = $query->offset($pages->offset)->limit($pages->limit)->distinct()->all();

        return $this->render(
            'categoria_detalle',
            [
                'producto_categoria' => $producto_categoria,
                'pagination'         => $pages,
                'maximo'             => $query->max('precio_pesos'),
                'minimo'             => $query->min('precio_pesos'),
                'prov'               => $get_prov,
                'title'              => $categoria
            ]
        );
    }


    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categoria();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 'Por revisar';
            if (Yii::$app->user->can('r-administrador-jagao'))
                $model->estado = 'Activo';
            $model->save();
            Yii::$app->notificador->enviarCorreoSolicitudCategoria($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->estado == 'Devuelto') {
                $model->estado = 'Por revisar';
                Yii::$app->notificador->enviarCorreoSolicitudCategoriaCorreccion($model);
            }
            if ($model->estado  != 'Activo') {
                $this->switchingStatus($id,6,1);
            } else {
                $this->switchingStatus($id,1,6);
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Categoria model.
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
     * Inactiva un proveedor y a la vez sus productos
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionInactivar($id, $observacion)
    {
        $this->switchingStatus($id, '2', '4', '1', $observacion);
    }

    /**
     * Activa un proveedor y a la vez sus productos
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivar($id)
    {
        $this->switchingStatus($id, '1', '1', '4');
    }

    public function switchingStatus($id,$estado_nuevo, $estado_viejo){
        $get_subcategory = Subcategoria::find()->where(['categoria_id' => $id])->all();
        if (!empty($get_subcategory)) {
            foreach ($get_subcategory as $subcategory) {
                $get_prod_sub = ProductoSubcategoria::find()->where(['subcategoria_id' => $subcategory->id])->all();
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
        }
    }


    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
