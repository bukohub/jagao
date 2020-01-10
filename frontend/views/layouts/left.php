<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            <i class="fa fa-user-circle fa-4" style="font-size: 40px;color:darkslategray;margin-left:5px;"></i>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php 
            $proveedor = \frontend\models\Proveedor::find()->where(['usuario_id' => Yii::$app->user->id])->all();
        ?>
        <?php

        $not_pro_admin = (!Yii::$app->user->can('r-administrador-jagao') and !Yii::$app->user->can('r-proveedor'));

        echo dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'Menú', 'options' => ['class' => 'header']],
                        ['label' => 'Página principal', 'icon' => 'home', 'url' => Yii::$app->homeUrl, 'target' => '_blank'],
                        [
                            'label' => 'Cliente',
                            'icon' => 'user',
                            'url' => '#',
                            'visible' => Yii::$app->user->can('r-proveedor'),
                            'items' => [
                                ['label' => 'Calificar un producto', 'icon' => 'thumbs-o-up', 'url' => ['/producto-calificacion/me/']],
                                ['label' => 'Productos Calificados', 'icon' => 'thumbs-up', 'url' => ['/producto-calificacion']],
                                ['label' => 'Mis Preguntas', 'icon' => 'question-circle-o', 'url' => ['/pregunta-producto/me/']],
                                ['label' => 'Mis Compras', 'icon' => 'money', 'url' => ['/producto-compras/mis-compras']],
                                ['label' => 'Mis direcciones', 'icon' => 'map-marker', 'url' => ['/direccion-cliente']],   
                            ]
                        ],
                        [
                            'label' => 'Proveedor',
                            'icon' => 'user-o',
                            'url' => '#',
                            'visible' => Yii::$app->user->can('r-proveedor'),
                            'items' => [
                                ['label' => 'Información Proveedor', 'icon' => 'truck', 'url' => ['/proveedor/detalle']],
                                ['label' => 'Productos', 'icon' => 'shopping-basket', 'url' => ['/producto']],
                                ['label' => 'Descuentos', 'icon' => 'money', 'url' => ['/producto-descuentos']],
                                ['label' => 'Productos Calificados', 'icon' => 'thumbs-up', 'url' => ['/producto-calificacion/proveedor']],//FIXME
                                ['label' => 'Preguntas de Productos', 'icon' => 'question-circle', 'url' => ['/pregunta-producto']],
                                ['label' => 'Compras de Productos', 'icon' => 'line-chart', 'url' => ['/producto-compras']]
                            ]
                        ],
                        Yii::$app->user->can('r-super-admin')?['label' => 'Administración', 'icon' => 'black-tie', 'url' => ['/backend/web'], 'target' => '_blank']:null,
                        Yii::$app->user->can('r-super-admin')?['label' => 'Acerca de Jagao', 'icon' => 'info', 'url' => ['/acerca-jagao'], 'target' => '_blank']:null,
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Banners', 'icon' => 'image', 'url' => ['/imagen-banner']]:null,
                        Yii::$app->user->can('r-super-admin')?['label' => 'Términos y Condiciones', 'icon' => 'info', 'url' => ['/terminos-jagao'], 'target' => '_blank']:null,
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],        
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Clientes', 'icon' => 'user', 'url' => ['/user']]:null,                
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Proveedores', 'icon' => 'truck', 'url' => ['/proveedor']]:null,
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Categorías', 'icon' => 'tag', 'url' => ['/categoria']]:null,
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Subcategorías', 'icon' => 'tag', 'url' => ['/subcategoria']]:null,
                        (Yii::$app->user->can('r-administrador-jagao')) ?['label' => 'Productos', 'icon' => 'shopping-basket', 'url' => ['/producto']]:null,
                        $not_pro_admin ? ['label' => 'Calificar un producto', 'icon' => 'thumbs-o-up', 'url' => ['/producto-calificacion/me/']] : null,
                        !Yii::$app->user->can('r-proveedor') ? ['label' => 'Productos Calificados', 'icon' => 'thumbs-up', 'url' => ['/producto-calificacion']]:null,
                        $not_pro_admin ? ['label' => 'Mis Preguntas', 'icon' => 'question-circle-o', 'url' => ['/pregunta-producto/me/']] : null,
                        Yii::$app->user->can('r-administrador-jagao') ?['label' => 'Preguntas de Productos', 'icon' => 'question-circle', 'url' => ['/pregunta-producto']]:null,
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Tipo de Reporte Productos', 'icon' => 'exclamation-triangle', 'url' => ['/tipo-reporte-producto']]:null,
                        Yii::$app->user->can('r-administrador-jagao')?['label' => 'Reportes de productos', 'icon' => 'exclamation-triangle', 'url' => ['/reporte-producto']]:null,
                        $not_pro_admin ? ['label' => 'Mis Compras', 'icon' => 'money', 'url' => ['/producto-compras/mis-compras']] : null,
                        (Yii::$app->user->can('r-administrador-jagao'))?['label' => 'Compras de Productos', 'icon' => 'line-chart', 'url' => ['/producto-compras']]:null,
                        (!Yii::$app->user->can('r-proveedor') && empty($proveedor) and ! Yii::$app->user->can('r-administrador-jagao'))?['label' => '¡Quiero vender en JAGAO.CO!', 'icon' => 'money', 'url' => ['/proveedor/primera-vez']]:null,
                        (Yii::$app->user->can('r-solicitante-proveedor') and !Yii::$app->user->can('r-administrador-jagao')) ?['label' => 'Estado solicitud', 'icon' => 'clock-o', 'url' => ['/proveedor/solicitud']]:null,
                        $not_pro_admin ? ['label' => 'Mis direcciones', 'icon' => 'map-marker', 'url' => ['/direccion-cliente']]:null
                    ],
                ]
        )
        ?>

    </section>

</aside>
