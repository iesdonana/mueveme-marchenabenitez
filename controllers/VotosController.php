<?php

namespace app\controllers;

use app\models\Votos;
use app\models\VotosSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VotosController implements the CRUD actions for Votos model.
 */
class VotosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Votos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VotosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Votos model.
     * @param int $usuario_id
     * @param int $comentario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($usuario_id, $comentario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($usuario_id, $comentario_id),
        ]);
    }

    /**
     * Creates a new Votos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Votos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/noticias/view', 'id' => $model->comentario->noticia_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Votos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $usuario_id
     * @param int $comentario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($usuario_id, $comentario_id)
    {
        $model = $this->findModel($usuario_id, $comentario_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'usuario_id' => $model->usuario_id, 'comentario_id' => $model->comentario_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Votos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $usuario_id
     * @param int $comentario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($usuario_id, $comentario_id)
    {
        $this->findModel($usuario_id, $comentario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Votos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $usuario_id
     * @param int $comentario_id
     * @return Votos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($usuario_id, $comentario_id)
    {
        if (($model = Votos::findOne(['usuario_id' => $usuario_id, 'comentario_id' => $comentario_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}