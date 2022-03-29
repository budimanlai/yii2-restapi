<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%app}}`.
 */
class m201211_163653_create_app_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%app}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string(50)->notNull(),
            'api_key' => $this->string(32)->notNull()->unique(),
            'auth_key' => $this->string(64)->notNull(),
            'status' => $this->string(15)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'last_access_at' => $this->dateTime()
        ], $tableOptions);
        
        $this->createTable('{{%user_session}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'app_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'token' => $this->string(32)->notNull()->unique(),
            'created_at' => $this->dateTime()->notNull(),
            'removed_at' => $this->dateTime(),
            'from_ip' => $this->string(15),
            'user_agent' => $this->string(256)
        ], $tableOptions);
        
        $this->addForeignKey('fk_session_app', '{{%user_session}}', 'app_id', 
                '{{%app}}', 'id', null, 'cascade');
        
        $this->addForeignKey('fk_session_user', '{{%user_session}}', 'user_id', 
                '{{%user}}', 'id', null, 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%user_session}}');
        $this->dropTable('{{%app}}');
    }
}
