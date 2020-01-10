<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        Se ha realizado una revisión sobre tu solicitud para ofertar tus productos,
        lo siguiente es el resultado, revisalo y sigue los pasos que se te indican a 
        continuación.
    </p>
    <br>
    <strong>Resultado :</strong> <?= $model->resultado ?>
    <br>
    <strong>Observación :</strong> <?= $model->observacion ?>
    <br>
    <p>
        <?php if ($model->resultado == 'Aprobado') { ?>
            Ahora podras publicar tus productos en JAGAO, desde este momento en tu
            cuenta encontraras habilitados los apartados de "Categorias","Proveedores" y 
            "Productos", desde allí podras gestionar toda la información de tus ofertas.
        <?php } elseif ($model->resultado == 'Devuelto') { ?>
            Desafortunadamente tu solicitud fue devuelta pero no te preocupes esto no significa
            que no puedes continuar solo debes tener en cuenta lo que se indica en la observación 
            realiza las modificaciones sugeridas y las personas que hacen la magia en JAGAO 
            revisaran de nuevo tu solicitud, ¡ANIMO!.

            Encontraras habilitado el apartado de "Proveedores", allí podras actualizar tu
            solicitud.
        <?php } elseif ($model->resultado == 'Rechazado') { ?>
            Desafortunadamente tu solicitud fue rechazada, no es el fin, puedes volver a 
            registrar una solicitud para que ofertes tus productos en JAGAO solo ten en 
            cuenta la observación por la cual fue rechazada tu solicitud, ¡ANIMO!.
        <?php } ?>
    </p>
    <?=
    Html::a('Consulta el resultado aquí.', Url::home('http') . ('/proveedor/view?id=' . $model->proveedor_id))
    ?>

</div>

<br><br>
Atentamente,
<br>
<br>
Sistema de notificaciones de JAGAO
<br>
<br>
<strong>Esta es una notificación automática, por favor no responda este mensaje</strong>