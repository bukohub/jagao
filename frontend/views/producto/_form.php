<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use frontend\models\Proveedor;
use yii\helpers\ArrayHelper;
use kartik\widgets\TouchSpin;
use kartik\number\NumberControl;
use frontend\models\Tag;
use frontend\models\Subcategoria;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use unclead\multipleinput\MultipleInput;
use frontend\models\Talla;

/* @var $this yii\web\View */
/* @var $model frontend\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(['id'=>'producto_form']); ?>

    <div class="row">
        <div class="col-sm-12">
            <i class="fa fa-outdent" aria-hidden="true"></i> <label>Nombre</label>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <i class="fa fa-align-justify" aria-hidden="true"></i> <label>Descripción</label>
            <?= $form->field($model, 'descripcion')->textarea(['rows' => 5])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <i class="fa fa-money" aria-hidden="true"></i> <label>Precio en pesos (COP)</label>
            <?=
                $form->field($model, 'precio_pesos')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'allowMinus' => false,
                        'radixPoint' => ','
                    ],
                    'options' => [
                        'id' => 'precio-pesos'
                    ]
                ])->label(false)
            ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <i class="fa fa-bookmark" aria-hidden="true"></i> <label>Categorias / Subcategorías</label>
            <?php
            $data =  ArrayHelper::map(Subcategoria::find()->joinWith('categoria')->where(['subcategoria.estado' => 'Activo'])->andWhere(['categoria.estado' => 'Activo'])->all(), 'id', 'nombre', 'categoria.nombre');
            echo $form->field($model, 'subcategorias')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione ...', 'multiple' => true],
                'pluginOptions' => [
                    'tokenSeparators' => [',', ' '],
                    'allowClear' => true
                ],
            ])->label(false)
            ?>
        </div>
        <div class="col-sm-6">
            <i class="fa fa-tags" aria-hidden="true"></i> <label>Tags</label>
            <?php
            $data = ArrayHelper::map(Tag::find()->all(), 'descripcion', 'descripcion');
            echo $form->field($model, 'tags')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Seleccione ...', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 20
                ],
            ])->label(false)
            ?>
        </div>
    </div>

    <div class="row no_es_ropa hidden">
        <div class="col-sm-12">
            <?=
                $form->field($model, 'producto_colors')->widget(MultipleInput::className(), [
                    'min' => 1,
                    'columns' => [
                        [
                            'name' => 'codigo_color',
                            'title' => 'Color',
                            'type' => \kartik\color\ColorInput::className(),
                            'enableError' => true,
                            'value' => function ($data) {
                                return $data['codigo_color'];
                            },
                        ],
                        [
                            'name' => 'cantidad',
                            'type' => \kartik\touchspin\TouchSpin::className(),
                            'title' => 'Cantidad',
                            'value' => function ($data) {
                                return $data['cantidad'];
                            },
                            'options' => [
                                'pluginOptions' => [
                                    'min' => 1, 'readonly' => true
                                ]
                            ]
                        ],
                    ]
                ])->label('<i class="fa fa-hashtag" aria-hidden="true"></i> Disponibilidad por color');
            ?>
        </div>
    </div>
    <div class="row es_ropa">
        <div class="col-sm-12">
            <?=
                $form->field($model, 'producto_tallas')->widget(MultipleInput::className(), [
                    'min' => 1,
                    'addButtonPosition' => MultipleInput::POS_ROW,
                    'cloneButton'=>true,
                    'columns' => [
                        [
                            'name' => 'codigo_color',
                            'title' => 'Color - <span style="font-weight:normal;">Si no aplica color, dejar vacío.</span>',
                            'type' => \kartik\color\ColorInput::className(),
                            'enableError' => true,
                            'options' => [
                                'showDefaultPalette' => false,
                                'options' => ['placeholder' => 'No aplica color', 'readonly' => true],
                                'pluginOptions' => [
                                    'showInput' => false,
                                    'showInitial' => true,
                                    'showPalette' => true,
                                    'showPaletteOnly' => true,
                                    'showSelectionPalette' => true,
                                    'showAlpha' => false,
                                    'allowEmpty' => true,
                                    'preferredFormat' => 'name',
                                    'palette' => [
                                        [
                                          "white", "black", "grey", "silver", "gold", "brown",
                                        ],
                                        [
                                            "red", "orange", "yellow", "indigo", "maroon", "pink"
                                        ],
                                        [
                                            "blue", "green", "violet", "cyan", "magenta", "purple",
                                        ],
                                    ]
                                ],
                                'addon' => ['append' => ['content'=>Html::button('No Aplica', ['class' => 'btn btn-primary not_color']), 'asButton'=>true]],


                            ],
                            'value' => function ($data) {
                                return $data['codigo_color'];
                            },
                        ],
                        [
                            'type' => \kartik\select2\Select2::class,
                            'name' => 'talla_id',
                            'title' => 'Talla',
                            'options' => [
                                'data' => ArrayHelper::map(Talla::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'descripcion'),
                                'options' => [
                                    'placeholder' => 'Seleccionar...',
                                ]
                            ],
                            'enableError' => true,
                        ],
                        [
                            'name' => 'cantidad',
                            'type' => \kartik\touchspin\TouchSpin::className(),
                            'title' => 'Cantidad',
                            'value' => function ($data) {
                                return $data['cantidad'];
                            },
                            'options' => [
                                'pluginOptions' => [
                                    'min' => 1
                                ]
                            ]
                        ],
                    ]
                ])->label('<i class="fa fa-hashtag" aria-hidden="true"></i> Disponibilidad por color');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?=
                $form->field($model, 'aplica_envio')->radioList([0 => 'No', 1 => 'Si']);
            ?>
        </div>
    </div>


    <div class="row envio_" style="display:none;">
        <div class="col-sm-4">
            <i class="fa fa-money" aria-hidden="true"></i> <label>Precio envío unidad adicional (COP)</label>

            <?=
                $form->field($model, 'precio_envio')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'allowMinus' => false,
                        'radixPoint' => ','
                    ],
                    'options' => [
                        'id' => 'precio_envio'
                    ]
                ])->label(false)
            ?>
        </div>
        <div class="col-sm-4">
            <i class="fa fa-money" aria-hidden="true"></i> <label>Precio envío adicional (COP)</label>

            <?=
                $form->field($model, 'precio_envio_adicional')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'prefix' => '$ ',
                        'groupSeparator' => '.',
                        'allowMinus' => false,
                        'radixPoint' => ','
                    ],
                    'options' => [
                        'id' => 'precio_envio_adicional'
                    ]
                ])->label(false)
            ?>
        </div>
        <div class="col-sm-4">
            <i class="fa fa-hashtag" aria-hidden="true"></i> <label>¿A partir de cuántos productos el envío es gratis?</label>

            <?=
                $form->field($model, 'cantidad_gratis_envio')->textInput(['type' => 'number'])->label(false) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-4">
            <i class="fa fa-picture-o" aria-hidden="true"></i> <label>Portada</label>
            <?=
                $form->field($model, 'imagen_principal')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*',
                        'required' => $model->isNewRecord ? true : false
                    ],
                    'pluginOptions' => [
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-danger',
                    ]
                ])->label(false);
            ?>
        </div>
        <div class="col-sm-8">
            <p>
                <i class="fa fa-camera" aria-hidden="true"></i> <label>Imagenes segundarias</label>
                <?=
                    FileInput::widget([
                        'model' => $model,
                        'attribute' => 'imagenes_segundarias',
                        'options' => ['multiple' => true, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                            'browseClass' => 'btn btn-danger',
                        ]
                    ]);
                ?>
            </p>
        </div>
    </div>
    <?php if (isset($imagenPrincipal)) : ?>
        <div class="row">
            <div class="col-sm-4">
                <i class="fa fa-picture-o" aria-hidden="true"></i> <label>Portada actual</label>
                <div class="card">
                    <div class="card-image text-center">
                        <img width="100%" src="<?= Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesProductos'] . $imagenPrincipal->nombre_archivo) ?>">

                    </div><!-- card image -->
                    <div class="card-action text-right">
                        <?php
                            Modal::begin([
                                'headerOptions' => [
                                    'style' => 'background-color:#dd4b39;'
                                ],
                                'toggleButton' => [
                                    'label' => '<span class="glyphicon glyphicon-resize-full"></span>',
                                    'class' => 'btn btn-default'
                                ],
                            ]);
                            ?>
                        <div class="text-center">
                            <img class="img-responsive" src="<?= Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesProductos'] . $imagenPrincipal->nombre_archivo) ?>">
                        </div>
                        <?php
                            Modal::end();
                            ?>
                    </div><!-- card actions -->
                </div>
            </div>
            <?php if (isset($imagenesSegundarias)) : ?>
                <div class="col-sm-8">
                    <i class="fa fa-camera" aria-hidden="true"></i> <label>Imagenes segundarias cargadas</label>
                    <div class="container-fluid">
                        <div class="row">
                            <?php foreach ($imagenesSegundarias as $imagen) : ?>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-image text-center">
                                            <img style="max-height: 65px;" class="img-responsive" src="<?= Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesProductos'] . $imagen->nombre_archivo) ?>">
                                        </div><!-- card image -->
                                        <div class="card-action">
                                            <?php
                                                        Modal::begin([
                                                            'headerOptions' => [
                                                                'style' => 'background-color:#dd4b39;'
                                                            ],
                                                            'toggleButton' => [
                                                                'label' => '<span class="glyphicon glyphicon-resize-full"></span>',
                                                                'class' => 'btn btn-default'
                                                            ],
                                                        ]);
                                                        ?>
                                            <div class="text-center">
                                                <img class="img-responsive" src="<?= Yii::$app->urlManager->createUrl(Yii::$app->params['urlImagenesProductos'] . $imagen->nombre_archivo) ?>">
                                            </div>
                                            <?php
                                                        Modal::end();
                                                        ?>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-eliminar-imagen" id-imagen="<?= $imagen->id ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </div><!-- card actions -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?php
                Modal::begin([
                    'header' => '<h2><span class="glyphicon glyphicon-warning-sign"></span> ¡ATENCIÓN!</h2>',
                    'headerOptions' => [
                        'style' => 'background-color:#dd4b39;color:#fff;'
                    ],
                    'toggleButton' => [
                        'label' => '<span class="glyphicon glyphicon-floppy-saved"></span> Guardar',
                        'class' => 'btn btn-lg btn-success pull-right btn-guardar'
                    ],
                ]);
                ?>
                <p style="font-size: 20px;">
                    Se guardará el producto con las siguientes especificaciones:
                </p>
                <div style="font-size: 15px;">
                    <p>
                        <label>Nombre :</label> <span class="nombre"></span>
                    </p>
                    <p>
                        <label>Descripción :</label> <span class="descripcion"></span>
                    </p>
                    <p>
                        <label>Categorias :</label> <span class="categorias"></span>
                    </p>
                    <p>
                        <label>Proveedor :</label> <span class="proveedor"><?php echo @Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one()->nombre; ?> </span>
                    </p>
                    <p>
                        <label>Cantidad en stock :</label> <span class="cantidad"></span>
                    </p>
                    <p>
                        <label>Precio en pesos :</label> <span class="pesos"></span>
                    </p>

                    <div class="alert alert-success">
                        <div class="text-center">
                            <h3><span class="glyphicon glyphicon-warning-sign"></span></h3>
                        </div>
                        <p>
                            Si los datos confirmados son correctos, por favor da clic en
                            "Continuar", de lo contrario da click en "Cancelar" para regresar al formulario.
                        </p>
                    </div>
                    <div class="alert alert-danger">
                        <div class="text-center">
                            <h3><span class="glyphicon glyphicon-warning-sign"></span></h3>
                        </div>
                        <p>
                            Si se presenta el caso en que das clic en “Continuar” y el formulario no se envía, esto es debido a que ingresaste información errada en el formulario o hace falta la misma. Por favor regresa al formulario y corrige los errores que se te indican.
                        </p>
                    </div>
                </div>

                <div class="text-right">
                    <a class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <span class="glyphicon glyphicon-remove-sign"></span> Cancelar
                    </a>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Continuar', ['class' => 'btn btn-success']) ?>
                </div>
                <?php
                Modal::end();
                ?>

            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    $this->registerJsFile(
        '@web/js/producto.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]
    );
    ?>

</div>