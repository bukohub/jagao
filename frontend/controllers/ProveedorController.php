<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Proveedor;
use frontend\models\ProveedorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AuthAssignment;
use common\models\User;
use frontend\models\Producto;
use yii\data\Pagination;
use yii\filters\AccessControl;

/**
 * ProveedorController implements the CRUD actions for Proveedor model.
 */
class ProveedorController extends Controller
{

    public $layout = 'main-admin';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Proveedor models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('r-administrador-jagao')) {
        $searchModel = new ProveedorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
    }

    /**
     * Lists all Proveedor models.
     * @return mixed
     */
    public function actionPrimeraVez()
    {

        return $this->render('_primera_vez', []);
    }

    /**
     * Displays a single Proveedor model.
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
     * Displays a single Proveedor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetalle()
    {
        $model = Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Proveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($primerVez = null)
    {
        if ($primerVez) {
            $model = new Proveedor();
            if ($model->load(Yii::$app->request->post())) {
                $model->estado_id = 4;
                $model->usuario_id = Yii::$app->user->id;
                $model->contrato   = (int) Yii::$app->request->post()['Proveedor']['contrato'];
                $model->almacenarDocumento($model);
                $model->almacenarCertificadoBank($model);
                if (!$model->save()) {
                    print_r($model->getErrors());
                    die();
                }
                $model->almacenarImagen();

                $model->almacenarProveedor();
                if (!Yii::$app->user->can('r-proveedor') && !Yii::$app->user->can('r-solicitante-proveedor')) {
                    $asignarPermiso = new AuthAssignment();
                    $asignarPermiso->user_id = $model->creado_por;
                    $asignarPermiso->item_name = 'r-solicitante-proveedor';
                    if (!$asignarPermiso->save()) {
                        print_r($asignarPermiso->getErrors());
                        die();
                    }
                }
                Yii::$app->notificador->enviarCorreoSolicitudProveedor($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
                'primerVez' => $primerVez
            ]);
        }
    }

    /**
     * Updates an existing Proveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('r-proveedor')) {
            $model = $this->findModel($id);
            $imagen = $model->imagenProveedors;

            if ($model->load(Yii::$app->request->post())) {
                if ($model->estado_id == 3) {
                    $model->estado_id = 4;
                }
                $model->contrato   = (int) Yii::$app->request->post()['Proveedor']['contrato'];
                if (!empty($_FILES['Proveedor']['name']['documento']))
                    $model->almacenarDocumento($model);
                if (!empty($_FILES['Proveedor']['name']['certificado_bk']))
                    $model->almacenarCertificadoBank($model);
                if (!empty($_FILES['Proveedor']['name']['imagen'])) {
                    $model->eliminarImagenActual();
                    $model->almacenarImagen();
                }
                if (!empty($_FILES['Proveedor']['name']['runt'])) {
                    $model->almacenarProveedor();
                }
                
                $model->save();
                if ($model->estado_id == 4) {
                    Yii::$app->notificador->enviarCorreoSolicitudProveedorCorreccion($model);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
                'imagen' => $imagen
            ]);
        }
    }

    /**
     * Inactiva un proveedor y a la vez sus productos
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionInactivar($id, $observacion)
    {
        $this->switchingStatus($id, '2', '4', '1',$observacion);
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

    /**
     * Cambia los estados de un producto
     * @param integer id
     * @param String $status_prov Estado del proveedor a cambiar
     * @param String $status_prod Estado del producto a cambiar
     * @param String $old_state Búsqueda del estado del producto actual
     * @return View Index
     */
    protected function switchingStatus($id, $status_prov, $status_prod, $old_state, $observacion = NULL)
    {
        if (Yii::$app->user->can('r-administrador-jagao')) {
            $get_proveedor = $this->findModel($id);
            $get_proveedor->estado_id = $status_prov;

            if ($status_prov == '2') {
                $get_email_prov  = User::findOne($get_proveedor->usuario_id);
                if(!empty($get_email_prov)){
                    $get_proveedor->mensaje_ina = $observacion;
                    Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
                    Yii::$app->params['textoTitulo'] = 'Inactivación de Usuario';
                    Yii::$app->mailer
                            ->compose(
                                ['html' => 'email-proveedor-desactivado'],
                                ['message' => $observacion ,'user'=>$get_email_prov]
                            )
                            ->setFrom([Yii::$app->params['supportEmail'] => 'JAGAO'])
                            ->setTo($get_email_prov->email)
                            ->setSubject('Inactivación proveedor ' . Yii::$app->name)
                            ->send();
                }
            }

            if ($get_proveedor->save()) {
                $get_producto = Producto::findAll(['proveedor_id' => $id, 'estado_producto_id' => $old_state]);
                foreach ($get_producto as $producto) {
                    $producto->estado_producto_id =  $status_prod;
                    $producto->save();
                }
            }
        }
        return $this->redirect(['index']);
    }


    /**
     * Finds the Proveedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proveedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proveedor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSolicitud()
    {
        $searchModel = new ProveedorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('_solicitud', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Realiza el listado de los productos por proveedor
     * @param type $idProveedor
     * @return type
     */
    public function actionListadoProductosProveedor($idProveedor)
    {
        $this->layout = 'main';
        $proveedor = Proveedor::findOne($idProveedor);
        $query = Producto::find()->where([
            'proveedor_id' => $proveedor->id,
            'estado_producto_id' => 1
        ]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 2]);
        $productos = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        //        echo '<pre>';
        //        print_r($productos);
        //        die();
        return $this->render('_listado_productos', [
            'productos' => $productos,
            'proveedor' => $proveedor,
            'pagination' => $pagination,
        ]);
    }
}
