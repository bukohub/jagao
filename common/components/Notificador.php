<?php

namespace common\components;

use Yii;
use yii\base\Component;
use backend\models\AuthAssignment;
use common\models\User;
use frontend\models\Proveedor;
use frontend\models\Categoria;

/**
 * La clase Notificador agrupa varias funciones para la generacion de
 * notificaciones
 * 
 * @author Fabian Augusto Aguilar Sarmiento <fabian.aguilars@autonoma.edu.co>
 */
class Notificador extends Component {

    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoSolicitudProveedor($param) {
        $administradoresJagao = AuthAssignment::find()->where(['item_name' => 'r-administrador-jagao'])->all();
        $correosANotificar = [];
        foreach ($administradoresJagao as $idusuario) {
            $correo = User::findOne($idusuario->user_id)->email;
            $correosANotificar[] = $correo;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Nueva solicitud para ofertar productos';
            Yii::$app->mailer->compose('solicitud-proveedor', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Se ha registrado una solicitud para ofertar productos')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoSolicitudProveedorCorreccion($param) {
        $administradoresJagao = AuthAssignment::find()->where(['item_name' => 'r-administrador-jagao'])->all();
        $correosANotificar = [];
        foreach ($administradoresJagao as $idusuario) {
            $correo = User::findOne($idusuario->user_id)->email;
            $correosANotificar[] = $correo;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Correciones sobre solicitud para ofertar productos';
            Yii::$app->mailer->compose('solicitud-proveedor-correccion', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Se ha registrado correcciones sobre una solicitud para ofertar productos')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoResultadoProveedor($param) {
        $proveedor = Proveedor::findOne($param->proveedor_id);
        $correosANotificar = [];
        $correosANotificar[] = $proveedor->creadoPor->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Resultado revisión solicitud de oferta de productos';
            if(!empty($param->observacion)){
                Yii::$app->mailer->compose('resultado-solicitud-proveedor', ['model' => $param])
                ->setFrom('jagao.notificaciones@gmail.com')
                ->setTo($correosANotificar)
                ->setSubject('AVISO: Se ha realizado una revisión sobre tu solicitud')
                ->send();
            }
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }

    
    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoSolicitudCategoria($param) {
        $administradoresJagao = AuthAssignment::find()->where(['item_name' => 'r-administrador-jagao'])->all();
        $correosANotificar = [];
        foreach ($administradoresJagao as $idusuario) {
            $correo = User::findOne($idusuario->user_id)->email;
            $correosANotificar[] = $correo;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Nueva solicitud para creación de una categoría';
            Yii::$app->mailer->compose('solicitud-categoria', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Se ha registrado una solicitud para crear una categoría')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    
    
    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoResultadoCategoria($param) {
        $categoria = Categoria::findOne($param->categoria_id);
        $correosANotificar = [];
        $correosANotificar[] = $categoria->creadoPor->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Resultado revisión solicitud creación de una categoría';
            Yii::$app->mailer->compose('resultado-solicitud-categoria', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Se ha realizado una revisión sobre tu solicitud')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    
    /**
     * Metodo para realizar el envio del email con la notificación al responsable
     * indicando que se ha realizado una nueva calificación
     */
    public static function enviarCorreoSolicitudCategoriaCorreccion($param) {
        $administradoresJagao = AuthAssignment::find()->where(['item_name' => 'r-administrador-jagao'])->all();
        $correosANotificar = [];
        foreach ($administradoresJagao as $idusuario) {
            $correo = User::findOne($idusuario->user_id)->email;
            $correosANotificar[] = $correo;
        }
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Correciones sobre solicitud para crear una categoría';
            Yii::$app->mailer->compose('solicitud-categoria-correccion', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Se ha registrado correcciones sobre una solicitud para crear una categoría')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    
    public static function enviarCorreoNuevaPregunta($param) {        
        $correosANotificar = [];
        $correosANotificar[] = $param->producto->creadoPor->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = 'Nueva pregunta';
            Yii::$app->mailer->compose('nueva-pregunta', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Alguien realizó una pregunta sobre uno de tus productos.')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
    
    public static function enviarCorreoRespuestaPregunta($param) {        
        $correosANotificar = [];
        $correosANotificar[] = $param->pregunta->creadoPor->email;
        try {
            Yii::$app->params['textoEncabezado'] = 'Notificaciones JAGAO';
            Yii::$app->params['textoTitulo'] = '¡Han respondido tu pregunta!';
            Yii::$app->mailer->compose('respuesta-pregunta', ['model' => $param])
                    ->setFrom('jagao.notificaciones@gmail.com')
                    ->setTo($correosANotificar)
                    ->setSubject('AVISO: Han respondido tu pregunta.')
                    ->send();
        } catch (Exception $ex) {
            print_r($ex);
            echo '<br/>';
        }
    }
}
