<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Noticias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Título') ?>

    <?= $form->field($model, 'noticia')->textarea(['rows' => 6])->label('Descripción') ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label('URL') ?>

    <?= $form->field($model, 'categoria_id')
             ->dropDownList(\app\models\Categorias::find()
             ->select('categoria')->indexBy('id')->column(),
             [
                 'prompt' => 'Seleccione la categoría'
             ])
             ->label('Categoría')
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
