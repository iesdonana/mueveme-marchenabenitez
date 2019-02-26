<?php

namespace app\commands;

use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;

class UsuariosController extends Controller
{
    public function actionLimpiar()
    {
        $pasado = new \DateTime();
        $pasado = $pasado->sub(new \DateInterval('P7D'))
            ->format('Y-m-d H:m:s');
        $numBorrados = Usuarios::deleteAll(
            'confirm = false AND created_at < :pasado',
            [':pasado' => $pasado]
        );

        echo "Se han borrado $numBorrados usuarios\n";
        return ExitCode::OK;
    }
}
