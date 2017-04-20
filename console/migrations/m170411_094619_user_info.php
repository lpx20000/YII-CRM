<?php

use yii\db\Migration;

class m170411_094619_user_info extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),

            'health' => $this->string(30),
            'specialty' => $this->string(20),
            'registered' => $this->date(),
            'registered_address' => $this->string(50),
            'graduate_date' => $this->date(),
            'graduate_colleages' => $this->string(20),
            'intro' => $this->string(255),
            'details' => $this->text(),

            'login_time' => $this->integer()->notNull(),
            'login_ip' => $this->char(12)->notNull(),
            'login_count' => $this->integer()->notNull(),

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%userInfo}}');
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
