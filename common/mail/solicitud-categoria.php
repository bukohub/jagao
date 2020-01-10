<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        El usuario <?=$model->creadoPor->username?> ha generado la creación de una 
        nueva categoría para poder iniciar el ofertamiento de sus productos pero
        antes de ello es necesario que usted cómo administrador de JAGAO confirme 
        la información que el usuario ingreso, una vez realice la revisión
        y confirme que es cierta en el detalle de la categoría tendrá disponible
        un botón en la esquina inferior derecha en el cual al dar click hará
        que aparezca una pequeña ventana donde usted debera indicar si aprueba o
        no la creación de esta categoría.
        <br>

        Consulte el registro por medio del enlace siguiente: 
    </p>
    <?=
    Html::a('Consulte este registro aquí.', Url::home('http') . ('/categoria/view?id=' . $model->id))
    ?>

</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de JAGAO
<br>
<br>
<i><strong>Esta es una notificación automática, por favor no responda este mensaje</strong></i>



