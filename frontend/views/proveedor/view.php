<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use frontend\models\ResultadoRevisionProveedor;

/* @var $this yii\web\View */
/* @var $model frontend\models\Proveedor */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proveedor-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <img width="5%" src="<?= Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesProveedores'] . $model->imagenProveedors->nombre_archivo) ?>">
    </h1>

    <?=
        DetailView::widget([
            'model' => $model,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<label class="label label-primary"> Pendiente </label>'],

            'attributes' => [
                'nombre',
                'descripcion:ntext',
                'identificacion_nit',
                'nombre_propietario',
                [
                    'attribute' => 'tipo_documento_propietario',
                    'value' => $model->tipoDocumentoPropietario->nombre
                ],
                'no_doc_propietario',
                [
                    'attribute' => 'usuario_id',
                    'label' => 'Usuario',
                    'value' => $model->usuario->username
                ],
                [
                    'attribute' => 'estado_id',
                    'label' => 'Estado',
                    'value' => $model->estado->descripcion
                ],
                [
                    'attribute' => 'banco',
                    'value' => $model->bancos->nombre
                ],
                [
                    'attribute' => 'tipo_cuenta',
                    'value' => function ($data) {
                        return $data->tipoCuenta->nombre;
                    }
                ], 'numero_cuenta',
                [
                    'attribute' => 'tipo_documento',
                    'value' => function ($data) {
                        return $data->tipoDocumento->nombre;
                    }
                ], 
                'no_documento', 'nombre_destinatario', 'contrato',
                [
                    'attribute' => 'runt',
                    'label' => 'RUT',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (!empty($data->runtProveedor->nombre_archivo))
                            return Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl( Yii::$app->params['rutRuntProveedores'] . $data->runtProveedor->nombre_archivo), ['target' => '_blank']);
                    },
                ],
                [
                    'attribute' => 'documento',
                    'label' => 'Documento Representante Legal',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (!empty($data->nombre_archivo))
                            return Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl( Yii::$app->params['rutDocProveedores'] . $data->nombre_archivo), ['target' => '_blank']);
                    },
                ],
                [
                    'attribute' => 'certificado_bk',
                    'label' => 'Certificado Bancario',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (!empty($data->nombre_cert))
                            return Html::a('Descargar archivo',  Yii::$app->urlManager->createUrl( Yii::$app->params['rutCertProveedores'] . $data->nombre_cert), ['target' => '_blank']);
                    },
                ],
                [
                    'attribute' => 'creado_por',
                    'value' => $model->creadoPor->username
                ],
                'creado_el',
            ],
        ])
    ?>

    <div>
        <?php
        if ($model->estado_id == 4 && Yii::$app->user->can('r-administrador-jagao')) {
            Modal::begin([
                'header' => '<h2>Resultado revisión</h2>',
                'headerOptions' => [
                    'style' => 'background-color:#dd4b39;color:#fff;'
                ],
                'toggleButton' => [
                    'label' => '<i class="fa fa-check-circle-o" aria-hidden="true"></i>',
                    'class' => 'btn btn-danger btn-lg pull-right'
                ],
            ]);
            $modelResultado = new ResultadoRevisionProveedor();
            echo $this->render('//resultado-revision-proveedor/_form', ['model' => new ResultadoRevisionProveedor(), 'idProveedor' => $model->id]);
            Modal::end();
        }
        ?>
    </div>

</div>