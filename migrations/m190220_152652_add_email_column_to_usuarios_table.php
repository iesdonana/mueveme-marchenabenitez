<?php

use yii\db\Migration;

/**
 * Handles adding email to table `usuarios`.
 */
class m190220_152652_add_email_column_to_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'email', 'VARCHAR(255) UNIQUE');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuarios', 'email');
    }
}
