<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees_tasks}}`.
 */
class m250000_000003_create_employees_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employees_tasks}}', [
            'employee_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'PRIMARY KEY(employee_id, task_id)',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
 
        $this->addForeignKey('fk-employees_tasks-employee_id', '{{%employees_tasks}}', 'employee_id', '{{%employees}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-employees_tasks-task_id', '{{%employees_tasks}}', 'task_id', '{{%tasks}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-employees_tasks-employee_id', '{{%employees_tasks}}');
        $this->dropForeignKey('fk-employees_tasks-task_id', '{{%employees_tasks}}');

        $this->dropTable('{{%employees_tasks}}');
    }
}
