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
                <div class="text-right">
                    <?php
                    $voto = new Votos();
                    ?>
                    <?= Html::beginForm(Url::to(['votos/votar'])) ?>
                    	<?= Html::hiddenInput('comentario_id', $model->id) ?>
                        <?= Html::hiddenInput('tipoVoto', 'true') ?>
                        <button type="submit" class="btn btn-success" aria-label="Left Align">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"><?=$voto->getPositivos($model->id)?></span>
                        </button>
                    <?= Html::endForm() ?>
                    <?= Html::beginForm(Url::to(['votos/votar'])) ?>
                    	<?= Html::hiddenInput('comentario_id', $model->id) ?>
                        <?= Html::hiddenInput('tipoVoto', 'false') ?>
                        <button type="submit" class="btn btn-danger" aria-label="Left Align">
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"><?=$voto->getNegativos($model->id)?></span>
                        </button>
                    <?= Html::endForm() ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
