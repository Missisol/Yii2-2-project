<?php

use yii\db\Migration;

/**
 * Class m190219_145832_create_project_user
 */
class m190219_145832_create_project_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('project_user', [
        'id' => $this->primaryKey(),
        'project_id' => $this->integer()->notNull(),
        'user_id' => $this->integer()->notNull(),
        'role' => 'ENUM("manager", "developer", "tester")',
      ]);

      $this->addForeignKey('fk_project_user_user_us', 'project_user', ['user_id'], 'user', ['id']);
      $this->addForeignKey('fk_project_user_project_pr', 'project_user', ['project_id'], 'project', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('project_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_145832_create_project_user cannot be reverted.\n";

        return false;
    }
    */
}
