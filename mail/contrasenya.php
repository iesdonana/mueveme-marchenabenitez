<?php
/* @var $this \yii\web\View view component instance */
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
?>
<h2>Puedes reestablecer su contraseña desde el enlace de abajo.</h2>
<?php $form = ActiveForm::begin([
    'action' => Url::to(['usuarios/cambiarcontrasenya'], true),
]);?>

<?= $form->field($model, 'nombre')->hiddenInput()->label(false)  ?>

<button type="submit" name="button">Reestablecer contraseña </button>
<?php ActiveForm::end() ?>
