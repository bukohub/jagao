<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        El usuario <?=$model->creadoPor->username?> ha generado correcciones sobre
        una solicitud para crear una categoría en JAGAO, por favor revise las
        correcciones realizadas y de un resultado a esta solicitud.
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



