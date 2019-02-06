<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="noticias-view">

    <div class="row">
        <div class="col-md-2">
            <button type="submit" class='btn btn-success'>Muévelo</button>
        </div>
        <div class="col-md-9">
            <h4><?= Html::a($model->titulo, $model->link) ?></h4>
            <p>por <b><?= $model->usuario->nombre ?></b> a <b><?= Url::to($model->link) ?></b>  publicado <?= Yii::$app->formatter->asDatetime($model->created_at, "short")  ?></p>
            <p><?= $model->noticia ?></p>
            <p><b><?= $model->categoria->categoria ?></b></p>
        </div>
 </div>
 <div class="row">
    <div class="col-md-9">
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
