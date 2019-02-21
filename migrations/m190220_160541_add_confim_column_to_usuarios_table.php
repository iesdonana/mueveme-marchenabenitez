<?php

use yii\db\Migration;

/**
 * Handles adding confim to table `usuarios`.
 */
class m190220_160541_add_confim_column_to_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'confirm', 'BOOLEAN DEFAULT FALSE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuarios', 'confirm');
    }
}
