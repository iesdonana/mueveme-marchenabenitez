<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Todas',
                'items' => [
                     ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                     '<li class="divider"></li>',
                     ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                ],
            ],
            ['label' => 'Todas', 'url' => ['/noticias/index/']],
            ['label' => 'Publicar', 'url' => ['/noticias/create']],
            Yii::$app->user->isGuest ? (
                '<li>'.
                    Html::a('Registrar usuario', ['usuarios/create'], ['class' => 'btn btn-link']) .
                '</li>'.
                '<li>' .
                    Html::a('Login', ['/site/login'], ['class' => 'btn btn-link']) .
                '</li>'
            ) : (
                '<li class="dropdown">' .
                    Html::a('Usuario <span class="caret"></span>',
                    [''],
                    [
                        'class' => 'dropdown-toggle',
                        'data-toggle'=>'dropdown',
                        'role'=>'button',
                        'aria-haspopup'=>'true',
                        'aria-expanded'=> 'false'
                    ]).
                      '<ul class="dropdown-menu">
                        <li>'.
                            Html::a('Modificar datos', ['usuarios/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default']) .
                        '</li>
                        <li>'.
                            Html::beginForm(['/site/logout'], 'post', ['class' => 'btn']) .
                                Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->nombre . ')',
                                    ['class' => 'btn btn-default']
                                ) .
                            Html::endForm() .
                        '</li>
                      </ul>
                </li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
