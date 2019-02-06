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
                <?= Html::a(Html::encode($model->titulo), Html::encode($model->link)) ?>
            </h4>
            <small>
                <?= 'Enviado por: ' .
                    Html::a(Html::encode($model->usuario->nombre),
                    ['usuarios/view', 'id' => $model->usuario_id])
                ?>
            </small>
            <p> <?= Html::encode($model->noticia) ?> </p>
            <p>
                <?= Html::a(count($model->comentarios) .
                    ' comentarios ', ['noticias/view', 'id' => $model->id]) .
                    Html::a(Html::encode($model->categoria->categoria),
                    ['noticias/index', 'NoticiasSearch[categoria_id]' => $model->categoria_id])
                ?>
            </p>
        </div>
    </div>
</div>
