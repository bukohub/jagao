<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        El vendedor del producto <?=$model->pregunta->producto->nombre?> ha 
        dado respuesta a tu pregunta
    </p>
    <p>
        <strong><?=$model->pregunta->descripcion?></strong>
        <br>
        <strong>Respuesta: </strong><?=$model->descripcion?>
        <br>
        Consulta el producto mediante el siguiente enlace: 
    </p>
    <?=
    Html::a('Consulte este producto aquí.', Url::home('http') . ('/producto/detalle-producto?idProducto=' . $model->pregunta->producto_id))
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