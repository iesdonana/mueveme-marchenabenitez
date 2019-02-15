<?php

use app\models\Comentarios;
use yii\helpers\Url;
use yii\db\Expression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


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
    <div class="well well-sm">COMENTARIOS</div>

    <?php
    if (!Yii::$app->user->isGuest):
        $com = new Comentarios();
        $com->usuario_id = Yii::$app->user->id;
        $com->created_at = new Expression('NOW()');
        $com->noticia_id = $model->id;

        $form = ActiveForm::begin([
            'method' => 'POST',
            'action' => Url::to(['comentarios/create']),
        ]); ?>

        <?= $form->field($com, 'comentario')->textarea(['rows' => 3])->label(false) ?>

        <?= $form->field($com, 'usuario_id')->textInput()->hiddenInput()->label(false) ?>

        <?= $form->field($com, 'noticia_id')->textInput()->hiddenInput()->label(false) ?>

        <?= $form->field($com, 'comentario_id')->textInput()->hiddenInput()->label(false) ?>

        <?= $form->field($com, 'created_at')->textInput()->hiddenInput()->label(false) ?>

        <div class="form-group">
            <button class="btn btn-xs btn-success" type="submit" name="button">Comentar</button>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif ?>

    <div class="container">
        <div class="col-md-12">
            <?php foreach ($comentarios as $comentario): ?>
                <?php if ($comentario->comentario_id == null): ?>
                    <?= $this->render('../comentarios/_comentario',
                    [
                        'model' => $comentario,
                    ]) ?>
                <?php endif; ?>
                <?php $offset = 1;?>
                <?php foreach ($comentario->getComentariosHijos() as $comentarioHijo): ?>
                    <?php if ($comentario->comentario_id != null) {
                        $offset += 1;
                    } ?>
                        <div <?='class="col-md-offset-'. $offset. '"' ?>>
                            <?= $this->render('../comentarios/_comentario',
                            [
                                'model' => $comentarioHijo,
                            ]) ?>
                        </div>
                <?php endforeach; ?>
                <?php $offset++ ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
