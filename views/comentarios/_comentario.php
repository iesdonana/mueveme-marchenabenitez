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
        </div>
    </div>
</div>
