<?php
use app\models\Votos;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
 ?>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?='#'. $model->id . ' ' .
            Html::a(Html::encode($model->usuario->nombre),
            ['usuarios/view', 'id' => $model->usuario_id], ['style' => 'color:white']) ?>
        </div>
        <div class="panel-body">
            <?= $model->comentario ?>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?php
                $voto = new Votos();
                $voto->usuario_id = Yii::$app->user->id;
                $voto->comentario_id = $model->id;
                $voto->voto = true;

                $form = ActiveForm::begin([
                    'method' => 'POST',
                    'action' => Url::to(['votos/create']),
                ]); ?>

                <?= $form->field($voto, 'usuario_id')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($voto, 'comentario_id')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($voto, 'voto')->checkbox()->hiddenInput()->label(false) ?>

                <div class="text-right votos">
                    <button type="submit" class="btn btn-success" aria-label="Left Align">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"><?=$voto->getPositivos($model->id)?></span>
                    </button>
                <?php ActiveForm::end(); ?>
                    <button type="button" class="btn btn-danger" aria-label="Left Align">
                        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                    </button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
