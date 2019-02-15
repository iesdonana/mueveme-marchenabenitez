<?php
use app\models\Votos;
use app\models\Comentarios;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$creado = Yii::$app->formatter->asDateTime($model->created_at, "short")

 ?>
 <style type="text/css">
    .col {
         display: inline-block;
    }
 </style>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?='#'. $model->id . ' ' .
            Html::a(Html::encode($model->usuario->nombre),
            ['usuarios/view', 'id' => $model->usuario_id], ['style' => 'color:white']) ?> .
            <?=$creado?>
        </div>
        <div class="panel-body">
            <?= $model->comentario ?>
            <?php if (!Yii::$app->user->isGuest): ?>
                <div class="text-right">
                    <div class="col">
                        <?php
                        $voto = new Votos();
                        ?>
                        <?= Html::beginForm(Url::to(['votos/votar'])) ?>
                        <?= Html::hiddenInput('comentario_id', $model->id) ?>
                        <?= Html::hiddenInput('tipoVoto', 'true') ?>
                        <button type="submit" class="btn btn-success" aria-label="Left Align" title="Votar positivo">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"><?=$voto->getPositivos($model->id)?></span>
                        </button>
                        <?= Html::endForm() ?>
                    </div>
                    <div class="col">
                        <?= Html::beginForm(Url::to(['votos/votar'])) ?>
                        <?= Html::hiddenInput('comentario_id', $model->id) ?>
                        <?= Html::hiddenInput('tipoVoto', 'false') ?>
                        <button type="submit" class="btn btn-danger" aria-label="Left Align" title="Votar negativo">
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"><?=$voto->getNegativos($model->id)?></span>
                        </button>
                        <?= Html::endForm() ?>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $com1 = new Comentarios();
                    $com1->usuario_id = Yii::$app->user->id;
                    $com1->created_at = new Expression('NOW()');
                    $com1->noticia_id = $model->noticia_id;
                    $com1->comentario_id = $model->id;
                    $form1 = ActiveForm::begin([
                        'method' => 'POST',
                        'action' => Url::to(['comentarios/responder']),
                    ]); ?>

                    <?= $form1->field($com1, 'comentario')->textarea(['rows' => 2])->label('Responder') ?>

                    <?= $form1->field($com1, 'usuario_id')->textInput()->hiddenInput()->label(false) ?>

                    <?= $form1->field($com1, 'noticia_id')->textInput()->hiddenInput()->label(false) ?>

                    <?= $form1->field($com1, 'comentario_id')->textInput()->hiddenInput()->label(false) ?>

                    <?= $form1->field($com1, 'created_at')->textInput()->hiddenInput()->label(false) ?>

                    <div class="form-group">
                        <button class="btn btn-xs btn-success" type="submit" name="button">Responder</button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            <?php endif ?>
        </div>
    </div>
</div>
