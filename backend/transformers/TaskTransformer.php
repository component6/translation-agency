<?php

namespace backend\transformers;

class TaskTransformer
{
    /**
     * @param  \common\models\Task  $task
     * @return array
     */
    public static function transform(\common\models\Task $task)
    {
        return [
            'id'            => $task->id,
            'title'         => $task->title,
            'status'        => $task->status,
            'employeesTask' => array_map(function ($employeesTask) {
                return [
                    'employee_id'      => $employeesTask->employee_id,
                    'task_id'          => $employeesTask->task_id,
                    'employee'         => $employeesTask->employee ? [
                            'id'              => $employeesTask->employee->id,
                            'title'           => $employeesTask->employee->title,
                            'status'          => $employeesTask->employee->status,
                            'employment_type' => $employeesTask->employee->employment_type,
                        ] : null,
                ];
            }, $task->employeesTask),
        ];
    }
}
