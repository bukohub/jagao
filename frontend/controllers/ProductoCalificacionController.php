<?php

namespace frontend\controllers;

use frontend\models\Producto;
use Yii;
use frontend\models\ProductoCalificacion;
use frontend\models\ProductoCalificacionSearch;
use frontend\models\ProductoCompras;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoCalificacionController implements the CRUD actions for ProductoCalificacion model.
 */
class ProductoCalificacionController extends Controller
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
     * Lists all ProductoCalificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoCalificacionSearch();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        $title        = 'Productos Calificados';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>$title,
            'button'=>false,
            'calif'=>false
        ]);
    }

    public function actionMe(){
        $searchModel = new ProductoCalificacionSearch();
        $dataProvider = $searchModel->searchMe(Yii::$app->request->queryParams, TRUE);
        $title        = 'Calificar un producto';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>$title,
            'button'=>true,
            'calif'=>true
        ]);
    }

    public function actionProveedor(){
        $searchModel = new ProductoCalificacionSearch();
        $dataProvider = $searchModel->searchCalificaciones(Yii::$app->request->queryParams,FALSE, $proveedor = TRUE);
        $title        = 'Calificaciones de Productos';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>$title,
            'button'=>true,
            'calif'=>false
        ]);
    }

    /**
     * Displays a single ProductoCalificacion model.
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
     * Creates a new ProductoCalificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ProductoCalificacion();
                
        //Validaciones para crear una calificación
        $validations  = $this->validatorCreate($id);
        
        if(!$validations){
            return $this->render('//site/error', [
                'name' => 'Permiso Denegado',
                'message' => 'No puede calificar este producto.',
            ]);
        }

        // Almaceno la calificación
        if ($model->load(Yii::$app->request->post()) ) {
            $request               = Yii::$app->request;
            $model->producto_id    = $validations->producto_id;
            $model->calificacion   = $request->post()['ProductoCalificacion']['calificacion'];

            if(!$model->save()){
                print_r($model->getErrors());
                die();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model'   => $model,
            'products'=>$validations->producto
        ]);
    }

    /**
     * Valida si una persona puede crear una calificación en un producto 
     * @author Michael Rosero
     * @param int $id Id de la solicitud de compra
     * @return mixed
     */
    protected static function validatorCreate($id){
        $get_product = ProductoCompras::find()->where(['producto_compras.id'=>$id])->andWhere(['user_id'=>Yii::$app->user->id])->one();
        return empty($get_product) ? false : $get_product;
    }

    /**
     * Updates an existing ProductoCalificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $get_products = array(array('id'=>'11','nombre'=>'PS4'));//Producto Compras

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'products'=>$get_products
        ]);
    }

    /**
     * Deletes an existing ProductoCalificacion model.
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

    public function actionCalificaciones(){
        if(Yii::$app->user->can('r-proveedor')){

            $get_prov_id =  Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
            if(!empty($get_prov_id)){

                $searchModel = new ProductoCalificacionSearch();
                
                $dataProvider = $searchModel->searchMe(Yii::$app->request->queryParams);

                return $this->render('calificaciones', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

            }

        }
    }

    /**
     * Finds the ProductoCalificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductoCalificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductoCalificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
