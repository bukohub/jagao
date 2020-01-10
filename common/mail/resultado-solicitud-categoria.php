<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        Se ha realizado una revisión sobre tu solicitud para crear una nueva categoría,
        lo siguiente es el resultado, revisalo y sigue los pasos que se te indican.
    </p>
    <br>
    <strong>Resultado :</strong> <?= $model->resultado ?>
    <br>
    <strong>Observación :</strong> <?= $model->observacion ?>
    <br>
    <p>
        <?php if ($model->resultado == 'Aprobado') { ?>
            Ahora podras publicar tus productos en JAGAO asignandoles esta nueva categoría.
        <?php } elseif ($model->resultado == 'Devuelto') { ?>
            Desafortunadamente tu solicitud fue devuelta pero no te preocupes esto no significa
            que no puedes continuar solo debes tener en cuenta lo que se indica en la observación 
            realiza las modificaciones sugeridas y las personas que hacen la magia en JAGAO 
            revisaran de nuevo tu solicitud, ¡ANIMO!.

            Encontraras en el apartado de "Categorias" tu solicitud con estado "Devuelto" 
            y tambien tendras habilitada la opción de "Editar" la misma para realizar 
            las correcciones indicadas.
        <?php } elseif ($model->resultado == 'Rechazado') { ?>
            Desafortunadamente tu solicitud fue rechazada, no es el fin, puedes volver a 
            registrar una solicitud para que sea aprobada esta nueva categoría en JAGAO 
            solo ten en cuenta la observación por la cual fue rechazada tu solicitud, ¡ANIMO!.
        <?php } ?>
    </p>
    <?=
    Html::a('Consulta el resultado aquí.', Url::home('http') . ('/categoria/view?id=' . $model->id))
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