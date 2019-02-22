<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuariosSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->request->get('id') == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->email($model, $model->email);
            return;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_UPDATE;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->password = $model->password_repeat = '';

        return $this->render('update', [
           'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function email($model, $userMail)
    {
        if (Yii::$app->mailer->compose('validar', [
            'model' => $model,
        ])
            ->setFrom('muevememb@gmail.com')
            ->setTo($userMail)
            ->setSubject('Confirmar cuenta')
            //->setTextBody('Esto es una prueba.')
            //->setHtmlBody('<h1>Esto es una prueba</h1>')
            ->send()) {
            Yii::$app->session->setFlash('success', 'Se ha enviado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al mandar el correo.');
        }
        return $this->redirect(['site/index']);
    }

    public function emailContra($model, $userMail)
    {
        if (Yii::$app->mailer->compose('contrasenya', [
            'model' => $model,
        ])
            ->setFrom('muevememb@gmail.com')
            ->setTo($userMail)
            ->setSubject('Recuperar contraseña de Mueveme')
            //->setTextBody('Esto es una prueba.')
            //->setHtmlBody('<h1>Esto es una prueba</h1>')
            ->send()) {
            Yii::$app->session->setFlash('success', 'Se ha enviado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Ha habido un error al mandar el correo.');
        }
        return $this->redirect(['noticias/index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValidar()
    {
        $usuarios = Yii::$app->request->post('Usuarios');
        extract($usuarios);
        $usuario = Usuarios::find()->where(['nombre' => $nombre])->one();

        if (isset($usuario)) {
            $usuario->confirm = true;
            if ($usuario->save()) {
                Yii::$app->session->setFlash('success', 'Has validado tu cuenta correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'No se ha podido validad su cuenta.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No se encuentra su usuario.');
        }
        return $this->redirect(['site/index']);
    }

    public function actionRecuperarcontrasenya()
    {
        if ($email = Yii::$app->request->post('email')) {
            $usuario = Usuarios::findOne(['email' => $email]);
            if (isset($usuario)) {
                $this->emailContra($usuario, $email);
            } else {
                Yii::$app->session->setFlash('error', 'El email no es correcto.');
            }
        }
        return $this->render('recuperarcontrasenya');
    }

    public function actionCambiarcontrasenya()
    {
        $usuarios = Yii::$app->request->post('Usuarios');
        extract($usuarios);
        $usuario = Usuarios::find()->where(['nombre' => $nombre])->one();
        $usuario->scenario = Usuarios::SCENARIO_UPDATE;
        if (Yii::$app->request->isAjax && $usuario->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($usuario);
        }
        if ($usuario->load(Yii::$app->request->post()) && $usuario->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado su contraseña correctamente.');
            return $this->redirect(['noticias/index']);
        }
        $usuario->password = $usuario->password_repeat = '';
        return $this->render('cambiarcontrasenya', [
            'model' => $usuario,
        ]);
    }
}
