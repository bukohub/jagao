<?php

use frontend\models\Proveedor;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */



if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it. 
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    $get_prov = Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->one();

    if (!empty($get_prov)) {
        if ($get_prov->estado_id == 2) {
            ?>
            <div id="modal" class="iziModal" data-izimodal-loop="">

                <div class="modal-btns">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                                <p>Este usuario se encuentra inactivado por los administradores de Jagao. <br><br>
                                    "<b><?= $get_prov->mensaje_ina; ?></b>"
                                </p>
                            </div>
                            <div class="col-sm-12" style="text-align:center;margin: 0px 0 40 0;">
                                <a class="btn btn-default btn-lg " href="<?= Url::to(['site/logout']) ?>" data-method="post">Cerrar Sesión</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>

    <?php
            }
        }

        if (class_exists('backend\assets\AppAsset')) {
            backend\assets\AppAsset::register($this);
        } else {
            app\assets\AppAsset::register($this);
        }

        dmstr\web\AdminLteAsset::register($this);

        $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

        ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>JAGAO.CO | Tienda Virtual</title>
        <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/toastr.min.css" />
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/img/core-img/favicon.ico">
        <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/css_plantilla/izi.min.css">

        <?php $this->head() ?>
    </head>
    <style>
        .sidebar-collapse .fa-user-circle {
            font-size: 17px !important;
        }
    </style>

    <body class="hold-transition sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <?=
                    $this->render(
                        'header.php',
                        ['directoryAsset' => $directoryAsset]
                    )
                ?>

            <?=
                    $this->render(
                        'left.php',
                        ['directoryAsset' => $directoryAsset]
                    )
                ?>

            <?=
                    $this->render(
                        'content.php',
                        ['content' => $content, 'directoryAsset' => $directoryAsset]
                    )
                ?>

        </div>

        <?php $this->endBody() ?>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/toastr.min.js"></script>
        <script src="<?php echo Yii::$app->request->baseUrl; ?>/js/js_plantilla/izimodal.min.js"></script>
        <script>          
        try {
            $("#modal").iziModal({
                title: 'Usuario Suspendido',
                subtitle: 'Mensaje sobre su cuenta',
                headerColor: '#F08080',
                autoOpen: 0,
                closeOnEscape: false,
                closeButton: false,
                overlayClose: false,
            });
            $('#modal').iziModal('open');
            $('#ina_pro').modal('show');
        } catch (error) {
            
        }  
            
        </script>
    </body>

    </html>
    <?php $this->endPage() ?>
<?php } ?>