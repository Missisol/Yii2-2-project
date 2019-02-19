<?php

use yii\db\Migration;

/**
 * Class m190219_144233_create_project
 */
class m190219_144233_create_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('project', [
        'id' => $this->primaryKey(),
        'title' => $this->string(255)->notNull(),
        'description' => $this->text()->notNull(),
        'active' => $this->boolean()->notNull()->defaultValue(0),
        'creator_id' => $this->integer()->notNull(),
        'updater_id' => $this->integer(),
        'created_at' => $this->integer()->notNull(),
        'updated_at' => $this->integer(),
      ]);

      $this->addForeignKey('fk_project_user_cr', 'project', ['creator_id'], 'user', ['id']);
      $this->addForeignKey('fk_project_user_up', 'project', ['updater_id'], 'user', ['id']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('project');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190219_144233_create_project cannot be reverted.\n";

        return false;
    }
    */
}
