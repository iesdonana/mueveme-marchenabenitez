<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="noticias-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_portada',['model' => $model]);
        }
    ]); ?>
</div>
