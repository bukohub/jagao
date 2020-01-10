<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        El usuario <?=$model->creadoPor->username?> ha realizado una nueva pregunta sobre
        el producto <?=$model->producto->nombre?>, dale una respuesta lo más pronto posible y así poder tener un cliente satisfecho por tu atención. 
        <br>
        Consulta el registro por medio del siguient enlace: 
    </p>
    <?=
    Html::a('Consulte este registro aquí.', Url::home('http') . ('/pregunta-producto/view?id=' . $model->id))
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