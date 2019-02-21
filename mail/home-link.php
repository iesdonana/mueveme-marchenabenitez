<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<h2>Valida tu cuenta en Mueveme haciendo click abajo.</h2>
<?php $form = ActiveForm::begin([
    'action' => Url::to(['usuarios/validar'], true),
]);?>

<?= $form->field($model, 'nombre')->hiddenInput()->label(false)  ?>

<button type="submit" name="button">Validar email</button>
<?php ActiveForm::end() ?>
