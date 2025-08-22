<?php

namespace backend\modules\api\models\form;

use common\enums\TaskStatus;
use common\models\Employee;
use yii\base\Model;

class TaskEmployeesForm extends Model
{
    public $id;
    public $title;
    public $status;
    public $employeesIds;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'status'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => TaskStatus::getAllowedValues()],
            [['employeesIds'], 'safe'],
            [['employeesIds'], 'each', 'rule' => ['integer']],
            [['employeesIds'], 'validateEmployeeIds'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'           => 'Task ID',
            'title'        => 'Title',
            'status'       => 'Status',
            'employeesIds' => 'Employees',
        ];
    }

    public function validateEmployeeIds($attribute)
    {
        if (empty($this->employeesIds)) {
            return;
        }

        $notFound = array_diff(
            $this->employeesIds,
            Employee::find()->select('id')->where(['id' => $this->employeesIds])->column()
        );

        if (!empty($notFound)) {
            $this->addError($attribute, "Employee IDs do not exist: " . implode(', ', $notFound));
        }
    }
}
