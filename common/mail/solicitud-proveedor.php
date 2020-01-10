<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
    <p>
        El usuario <?=$model->creadoPor->username?> ha diligenciado el formulario de registro para ser proveedor de JAGAO.CO. Revisa y valida la solicitud en el siguiente enlace: 
        <br>
    </p>
    <?=
    Html::a('Consulte este registro aquí.', Url::home('http') . ('/proveedor/view?id=' . $model->id))
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



