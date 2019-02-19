<?php

use yii\db\Migration;

/**
 * Class m190219_143025_create_task
 */
class m190219_143025_create_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('task', [
        'id' => $this->primaryKey(),
        'title' => $this->string(255)->notNull(),
        'description' => $this->text()->notNull(),
        'project_id' => $this->integer(),
        'executor_id' => $this->integer(),
        'started_at' => $this->integer(),
        'completed_at' => $this->integer(),
        'creator_id' => $this->integer()->notNull(),
        'updater_id' => $this->integer(),
        'created_at' => $this->integer()->notNull(),
        'updated_at' => $this->integer(),
      ]);

      $this->addForeignKey('fk_task_user_ex', 'task', ['executor_id'], 'user', ['id']);
      $this->addForeignKey('fk_task_user_cr', 'task', ['creator_id'], 'user', ['id']);
      $this->addForeignKey('fk_task_user_up', 'task', ['updater_id'], 'user', ['id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('task');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_143025_create_task cannot be reverted.\n";

        return false;
    }
    */
}
