<?php

use yii\db\Migration;

class m170410_015202_nav extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%nav}}', [
            'id' => $this->primaryKey(),
            'text' => $this->char(10)->notNull(),
            'url' => $this->char(20),
            'iconCls' => $this->char(20)->notNull(),
            'pid' => $this->smallInteger(3)->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%nav}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
