<?php
/* @var $this \yii\web\View view component instance */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
?>
<h2>Su nombre de usuario en Mueveme es:</h2>
<?php $form = ActiveForm::begin();?>

<h4><?= Html::encode($model->nombre) ?></h4>

<?php ActiveForm::end() ?>
