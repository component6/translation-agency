<?php

namespace backend\services;

use common\models\EmployeeTask;
use common\models\Task;
use Exception;
use yii\helpers\ArrayHelper;

class TaskService
{
    /** @var \common\models\Task $model */
    protected $model;

    /**
     * @param  int|null  $task
     * @return void
     * @throws \Exception
     */
    public function __construct($taskId = null)
    {
        $this->model = !empty($taskId) ? Task::findOne($taskId) : new Task();

        if (empty($this->model)) {
            throw new \Exception('Model not found');
        }
    }

    /**
     * @param  array  $data
     * @return \common\models\Task
     * @throws \Exception
     */
    public function updateOrCreateTask($data)
    {
        $this->model->load($data, '');

        if (!$this->model->save()) {
            throw new Exception(json_encode($this->model->getErrors()));
        }

        $this->updateEmployeesTask($data['employeesIds'] ?? []);

        return $this->model;
    }

    /**
     * @param  array  $newEmployeeIds
     * @return void
     */
    private function updateEmployeesTask(array $newEmployeeIds = [])
    {
        $currentEmployeeTaskIds = ArrayHelper::getColumn($this->model->getEmployeesTask()->all(), 'employee_id');

        foreach ($currentEmployeeTaskIds as $employeeId) {
            if (!in_array($employeeId, $newEmployeeIds)) {
                EmployeeTask::deleteAll(['task_id' => $this->model->id, 'employee_id' => $employeeId]);
            }
        }

        foreach ($newEmployeeIds as $employeeId) {
            if (!in_array($employeeId, $currentEmployeeTaskIds)) {
                $employeeTask = new EmployeeTask();
                $employeeTask->task_id     = $this->model->id;
                $employeeTask->employee_id = $employeeId;
                $employeeTask->save();
            }
        }
    }
}
