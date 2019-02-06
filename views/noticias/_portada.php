<?php
// _list_item.php
use yii\helpers\Html;
?>

<div class="container">
    <div class="row">
        <div class="col-xs-1">
            <p> <?= count($model->movimientos) . ' mov.' ?> </p>
        </div>
        <div class="col-xs-11">
            <h4 class="titulo">
                <?= Html::a($model->titulo, $model->link) ?>
            </h4>
            <small><?= 'Enviado por: ' . Html::a($model->usuario->nombre) ?></small>
            <p> <?= $model->noticia ?> </p>
            <p> <?= count($model->comentarios) . ' comentarios ' .
            $model->categoria->categoria ?></p>
        </div>
    </div>
</div>
