<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Categorias;
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

<?php
$categorias = Categorias::find()->all();

$items = [
    [
        'label' => 'Todas',
        'url' => ['noticias/index', 'NoticiasSearch[categoria_id]' => ''],
    ],
];

foreach ($categorias as $categoria) {
    $items[] = '<li class="divider"></li>';
    $items[] = [
            'label' => $categoria->categoria,
            'url' => ['noticias/index', 'NoticiasSearch[categoria_id]' => $categoria->id],
    ];
}
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $url = explode("%2F", Yii::$app->request->url);
    if (count($url) == 1) {
        $ir = 'candidatas';
    } elseif ($url[1] == 'candidatas') {
        $ir = 'portada';
    } else {
        $ir = 'candidatas';
    }

    var_dump(count($_GET));


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => ucfirst($ir), 'url' => ["/noticias/$ir"]],
            ['label' => 'Más','items' => $items],
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
