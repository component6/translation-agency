<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employees_tasks}}".
 *
 * @property int $employee_id
 * @property int $task_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Employee $employee
 * @property Task $task
 */
class EmployeeTask extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employees_tasks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'task_id'], 'required'],
            [['employee_id', 'task_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['employee_id', 'task_id'], 'unique', 'targetAttribute' => ['employee_id', 'task_id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => Yii::t('app', 'Employee ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeTaskQuery(get_called_class());
    }

}
