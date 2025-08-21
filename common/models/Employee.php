<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employees}}".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property int|null $employment_type
 *
 * @property EmployeesTask[] $employeesTasks
 * @property Task[] $tasks
 */
class Employee extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employees}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employment_type'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['status', 'employment_type'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'Status'),
            'employment_type' => Yii::t('app', 'Employment Type'),
        ];
    }

    /**
     * Gets query for [[EmployeesTasks]].
     *
     * @return \yii\db\ActiveQuery|EmployeesTaskQuery
     */
    public function getEmployeesTasks()
    {
        return $this->hasMany(EmployeeTask::class, ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id'])->viaTable('{{%employees_tasks}}', ['employee_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }

}
