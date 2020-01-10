<?php 
use kartik\helpers\Html;

?>
<div class="container">
    <div class="jumbotron">
        <h1>¿Quieres ofertar tus productos en JAGAO.CO?</h1> 
        <p>Para iniciar es necesario que diligencies el formulario que hemos diseñado. Luego, revisaremos tu solicitud y se te confirmará por medio de correo electrónico el resultado de tu solicitud. Adelante, inténtalo.</p> 
        <div class="text-center">
            <?= Html::a('Diligencía el formulario aquí <i class="fa fa-truck" aria-hidden="true"></i>', ['create','primerVez' => true], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>