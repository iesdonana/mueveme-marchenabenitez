<?php
// _list_item.php
use yii\helpers\Html;
use Spatie\Dropbox\Client;


$url = explode("/", $model->link);
$creado = Yii::$app->formatter->asDateTime($model->created_at, "short");
$authorizationToken = 'xGZm6R8tGv8AAAAAAAAu5Z0fpfkx68D_sLA2L-GkpepuTEgSHar39xbOA1hoNKro';
$client = new Client($authorizationToken);
?>

<div class="container">
    <div class="row">
        <div class="col-md-1 text-center">
            <?= count($model->movimientos) . ' mov.' ?>
            <button type="button" class="btn btn-success">Muévelo</button>
        </div>
        <div class="col-md-11">
            <div class="row">
                <div class="col-xs-10">
                    <h4 class="titulo">
                        <?= Html::a(Html::encode($model->titulo), Html::encode($model->link)) ?>
                    </h4>
                    <small>
                        <?= 'por: ' .
                        Html::a(Html::encode($model->usuario->nombre),
                        ['usuarios/view', 'id' => $model->usuario_id])
                        . ' a ' . $url[2] . " " . $creado
                        ?>
                    </small>
                    <p> <?= Html::encode($model->noticia) ?> </p>
                    <p>
                        <?= Html::a(Html::encode(count($model->comentarios)) .
                        ' comentarios ', ['noticias/view', 'id' => $model->id]) .
                        Html::a(Html::encode($model->categoria->categoria),
                        ['noticias/index', 'NoticiasSearch[categoria_id]' => $model->categoria_id])
                        ?>
                    </p>
                </div>
                <div class="col-xs-1">
                    <br />
                    <?=
                        Html::img($client->getTemporaryLink('uploads/' . $model->id . '.png'))
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
