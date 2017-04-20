<?php

use yii\db\Migration;

class m170417_014916_user_extend extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_extend}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),
            'number' => $this->char(4)->notNull(),
            'gender' => $this->char(1)->notNull(),
            'post_id' => $this->integer(10)->notNull(),
            'type' => $this->char(4)->notNull(),
            'id_card' => $this->char(18)->notNull(),
            'tel' => $this->char(11)->notNull(),
            'nation' => $this->char(5)->notNull(),
            'marital_status' => $this->char(2),
            'entry_status' => $this->char(2),
            'entry_date' => $this->date(),
            'dismission_date' => $this->date(),
            'politics_status' => $this->char(2),
            'education' => $this->char(2),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user_extend}}');
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
