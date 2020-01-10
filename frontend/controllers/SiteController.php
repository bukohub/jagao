<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\AcercaJagao;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Producto;
use frontend\models\ProductoCompras;
use frontend\models\ProductoDescuentos;
use frontend\models\Proveedor;
use yii\db\Expression;

/**
 * Site controller
 */
class SiteController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','perfil'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','perfil'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @param $ref_payco Referencia de pago de Epayco
     * @return mixed
     */
    public function actionIndex($ref_payco = NULL)
    {
        $nuevosProductos = Producto::find()->where(['estado_producto_id' => 1])->orderBy(['creado_el' => SORT_DESC])->limit(4)->all();
        $mas_vendidos    = $this->getCompras()->andFilterWhere(['estado_id' => 1])->all(); 
        $proveedores     = Proveedor::find()->where(['estado_id' => 1])->all();

        return $this->render('index', [
            'productos' => $nuevosProductos,
            'proveedores' => $proveedores,
            'mas_vendidos' => $mas_vendidos
        ]);
    }

    /**
     * Método que obtiene los productos más vendidos y destacados
     */
    protected static function getCompras(){
        return ProductoCompras::find()->select(['COUNT(producto_id) as total','producto_id'])->joinWith('producto b')->where('b.estado_producto_id = 1')->groupBy(['producto_id'])->orderBy(['total' => SORT_DESC])->limit(4);
    }

    /**
     * Método que obtiene los productos desctacados
     * 
     */
    public static function destacados(){
        return self::getCompras()->all();
    }

    /**
     * Método que obtiene los últimos descuentos de los productos
     * 
     */
    public static function descuentos(){
        return ProductoDescuentos::find()->joinWith('producto b')->where('b.estado_producto_id = 1')->orderBy(new Expression('rand()'))->limit(4)->all();
    }

    public function actionView($id)
    {
        $productos       = Producto::find()->all();
        $nuevosProductos = Producto::find()->where(['estado_producto_id' => 1])->orderBy(['creado_el' => SORT_DESC])->limit(8)->all();
        $proveedores     = Proveedor::find()->where(['estado_id' => 1])->all();

        return $this->render('index', [
            'productos' => $nuevosProductos,
            'proveedores' => $proveedores
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * checkout
     */
    public function actionCheckout()
    {
        $model_user = User::findOne(Yii::$app->user->id);
        return $this->render('checkout', [  
            'user'=>$model_user
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAcercaJagao()
    {  
        $get_text = AcercaJagao::find()->all();
        return $this->render('about',['acerca'=>$get_text]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Gracias por tu registro, por favor verifica tu correo electrónico y confirma la cuenta por medio del link enviado.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Verifica tu correo electrónico para mas instrucciones');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Lo sentimos, no logramos restablecer la contraseña para la dirección de correo proporcionada.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Contraseña cambiada con éxito.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', '¡Tu cuenta ha sido verificada con éxito!');
                return $this->goHome();
            }
        }
        Yii::$app->session->setFlash('error', 'Lo sentimos, no pudimos confirmar tu cuenta.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Revisa tu correo para obtener más instrucciones.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Lo sentimos, no podemos reenviar el correo electrónico de verificación a la dirección de correo electrónico proporcionada.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionPerfil()
    {
        $this->layout = 'main-admin';
        return $this->render('//perfil/gestion_perfil');
    }



    public function actionDetalleCarrito()
    {
        $cart = Yii::$app->cart;
        $detalle = true;
        return $this->render('detalle_carrito', [
            'carrito' => $cart,
            'detalle' => $detalle,
        ]);
    }
}
