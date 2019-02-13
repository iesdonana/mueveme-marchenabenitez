<?php
use yii\helpers\Html;
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
            <div class="text-right votos">
                <button type="button" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>
