<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `usuarios`.
 */
class m190226_142851_add_created_at_column_to_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'created_at', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuarios', 'created_at');
    }
}
