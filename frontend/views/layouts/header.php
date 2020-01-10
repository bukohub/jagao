<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header" style="background-color: darkslategray; color: #fff;">

    <?=
    Html::a('<span class="logo-mini">'.
            '<img src="'.Yii::$app->request->baseUrl.'/img/core-img/'.'isotipo_color.png'.'" class="img-responsive" style="max-height: 45px !important;">'
            . '</span><span class="logo-lg">'
            . '<img src="'.Yii::$app->request->baseUrl.'/img/core-img/'.'isologotipo_horizontal_color.png'.'" class="img-responsive" >'.
            '</span>', Yii::$app->homeUrl, ['class' => 'logo'])
    ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user-circle fa-4" style="color:white;"></i>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->name ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                        <i class="fa fa-user-circle fa-4" style="font-size: 50px;color:darkslategray;margin-left:5px;"></i>

                            <p style="color:#000;">
<?= Yii::$app->user->identity->name ?>
                                <small>Jagaista desde <?= Yii::$app->user->identity->created_at ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--                        <li class="user-body">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Followers</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Sales</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Friends</a>
                                                    </div>
                                                </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Mi perfil</a>
                            </div>
                            <div class="pull-right">
                                <?=
                                Html::a(
                                        'Salir', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                )
                                ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <!--                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>-->
            </ul>
        </div>
    </nav>
</header>
