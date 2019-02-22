<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 /* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
    <div class="row">
        <h1>Recuperar Contraseña</h1>
    </div>
    <div class="row">
        <h4>Para recuperar la contraseña, debe indicar su email:</h4>
    </div>
    <br>
    <div class="row">

         <?php $form = ActiveForm::begin([
            'action' => ['usuarios/recuperarcontrasenya'],
        ]); ?>

        <div class="row">
             <?= Html::input('text','email') ?>
        </div>
        <br>
        <div class="form-group">
            <?= Html::submitButton('Recuperar', ['class' => 'btn btn-info']) ?>
        </div>

         <?php ActiveForm::end(); ?>
    </div>
</div>
