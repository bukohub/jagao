<?php

namespace frontend\controllers;

use Yii;
use frontend\models\TerminosJagao;
use frontend\models\TerminosJagaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TerminosJagaoController implements the CRUD actions for TerminosJagao model.
 */
class TerminosJagaoController extends Controller
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
     * Lists all TerminosJagao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TerminosJagaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TerminosJagao model.
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
     * Creates a new TerminosJagao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TerminosJagao();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TerminosJagao model.
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
     * Deletes an existing TerminosJagao model.
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

    public function actionTerminosContrato(){
        $this->layout = 'main';
        $message = TerminosJagao::find()->one()->texto_terminos_contrato;
        $title   = 'Términos del Contrato';
        return $this->render('term_c', [
            'title'=>$title,
            'texto_contrato' => $message,
        ]);
    }

    public function actionTerminosUsuario(){
        $this->layout = 'main';
        $message = TerminosJagao::find()->one()->texto_politica_datos;
        $title   = 'Términos del Registro de Usuario';
        return $this->render('term_c', [
            'title'=>$title,
            'texto_contrato' => $message,
        ]);
    }

    /**
     * Finds the TerminosJagao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TerminosJagao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TerminosJagao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
