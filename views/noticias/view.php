<?php

use yii\grid\GridView;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-view">
    <?= $this->render('_portada', [
        'model' => $model,
    ]) ?>

    <div class="row">
        <div class="col-md-12 text-center ">
            <?php if ($model->usuario_id == Yii::$app->user->id) : ?>
                <p>
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Borrar', ['delete', 'id' => $model->id, 'usuario_id' => $model->usuario_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Seguro que quieres borrar esta noticia?',
                            'method' => 'post',
                        ],
                        ]) ?>
                        <?= Html::a('Volver', ['noticias/index'], ['class' => 'btn btn-info']) ?>
                    </p>
                <?php else : ?>
                    <p>
                        <?= Html::a('Volver', ['noticias/index'], ['class' => 'btn btn-info']) ?>
                    </p>
                <?php endif ?>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <?php foreach ($comentarios as $comentario): ?>
                <?php if ($comentario->comentario_id == null) : ?>
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><?='#'. $comentario->id . ' ' .
                                Html::a(Html::encode($comentario->usuario->nombre),
                                ['usuarios/view', 'id' => $comentario->usuario_id], ['style' => 'color:white']) ?>
                            </div>
                            <div class="panel-body">
                                    <?= $comentario->comentario ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <div class="panel panel-primary col-md-offset-1">
                            <div class="panel-heading"><?='#'. $comentario->id . ' ' .
                                Html::a(Html::encode($comentario->usuario->nombre),
                                ['usuarios/view', 'id' => $comentario->usuario_id], ['style' => 'color:white']) ?>
                            </div>
                            <div class="panel-body">
                                <?= '#'. $comentario->comentario_id . ' ' . $comentario->comentario ?>    
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
