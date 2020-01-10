<?php

namespace frontend\controllers;

use Yii;
use frontend\models\DireccionCliente;
use frontend\models\DireccionClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\EstadoDepartamento;
use frontend\models\Municipio;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * DireccionClienteController implements the CRUD actions for DireccionCliente model.
 */
class DireccionClienteController extends Controller
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
                        'actions' => ['index', 'create','departamentos','ciudades','listado-departamento','listado-ciudad'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !empty(DireccionCliente::find()->where(['id' => Yii::$app->request->get('id'), 'usuario_id' => Yii::$app->user->id])->one());
                        }
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
     * Lists all DireccionCliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DireccionClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DireccionCliente model.
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
     * Creates a new DireccionCliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DireccionCliente();

        if ($model->load(Yii::$app->request->post())) {
            $model->usuario_id = Yii::$app->user->id;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDepartamentos()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {   
                $cat_id = $parents[0];
                $out = EstadoDepartamento::find()->select(['id','nombre as name'])->asArray()->where(['pais_id'=>$cat_id])->orderBy('nombre ASC')->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
    public function actionCiudades()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Municipio::find()->select(['id','nombre as name'])->asArray()->where(['departamento_id'=>$cat_id])->orderBy('nombre ASC')->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Updates an existing DireccionCliente model.
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
     * Deletes an existing DireccionCliente model.
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
     * Finds the DireccionCliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DireccionCliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DireccionCliente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionListadoDepartamento($idPais)
    {
        $municipios = EstadoDepartamento::find()->where(['pais_id' => $idPais])->orderBy('nombre ASC')->all();
        $opciones = '';
        if (count($municipios) > 0) {
            foreach ($municipios as $municipio) {
                $opciones .= "<option value='" . $municipio->id . "'>" . $municipio->nombre . "</option>";
            }
        } else {
            $opciones .= '<option>-</option>';
        }

        return $opciones;
    }
    public function actionListadoCiudad($idDepto)
    {
        $municipios = Municipio::find()->where(['departamento_id' => $idDepto])->orderBy('nombre ASC')->all();
        $opciones = '';
        if (count($municipios) > 0) {
            foreach ($municipios as $municipio) {
                $opciones .= "<option value='" . $municipio->id . "'>" . $municipio->nombre . "</option>";
            }
        } else {
            $opciones .= '<option>-</option>';
        }

        return $opciones;
    }
}
