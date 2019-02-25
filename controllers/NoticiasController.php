<?php

namespace app\controllers;

use app\models\Comentarios;
use app\models\Noticias;
use app\models\NoticiasSearch;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * NoticiasController implements the CRUD actions for Noticias model.
 */
class NoticiasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->request->post('usuario_id') == Yii::$app->user->id;
                        },
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
     * Lists all Noticias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticiasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noticias model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarios' => $this->buscaComentarios($id),
        ]);
    }

    /**
     * Creates a new Noticias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noticias();
        $model->usuario_id = Yii::$app->user->id;
        $model->created_at = new Expression('NOW()');


        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->save()) {
                $fileName = Yii::getAlias('@uploads/' . $model->id . '.' . $model->imageFile->extension);
                $model->imageFile->saveAs($fileName, $deleteTempFile = false);
                $imagine = new \Imagine\Gd\Imagine();
                $image = $imagine->open($fileName);
                $image->resize(new \Imagine\Image\Box(130, 100))->save($fileName);
                $res = $this->dropbox($fileName);
                $res->createSharedLinkWithSettings('/' . $fileName, ['requested_visibility' => 'public']);

                // En $res[‘url’] está la URL con el enlace compartido.
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Noticias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->save()) {
                $fileName = Yii::getAlias('@uploads/' . $model->id . '.' . $model->imageFile->extension);
                $model->imageFile->saveAs($fileName, $deleteTempFile = false);
                $imagine = new \Imagine\Gd\Imagine();
                $image = $imagine->open($fileName);
                $image->resize(new \Imagine\Image\Box(130, 100))->save($fileName);
                $this->dropbox($fileName);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Noticias model.
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

    /**
     * Finds the Noticias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Noticias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function buscaComentarios($id)
    {
        $comentarios = Comentarios::find()->where(
            [
                'noticia_id' => $id,
            ]
        )->all();
        return $comentarios;
    }

    private function dropbox($file = null)
    {
        $authorizationToken = 'xGZm6R8tGv8AAAAAAAAu5Z0fpfkx68D_sLA2L-GkpepuTEgSHar39xbOA1hoNKro';
        $client = new Client($authorizationToken);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter);
        if ($file != null) {
            $client->upload($file, file_get_contents($file), 'overwrite');
        }

        return $client;
    }
}
