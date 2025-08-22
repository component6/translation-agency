<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\form\TaskEmployeesForm;
use backend\services\TaskService;
use backend\transformers\TaskTransformer;
use common\enums\TaskStatus;
use common\models\Task;
use yii\web\Controller;

class TaskController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionTasks()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = ['status' => 400];

        $tasks = Task::find()->with('employeesTask', 'employeesTask.employee')->all();

        if (!empty($tasks)) {
            $response = [
                'status' => 200,
                'data'   => array_map(function ($task) {
                    return TaskTransformer::transform($task);
                }, $tasks),
            ];
        }

        return $response;
    }

    /**
     * @return string
     */
    public function actionFieldsTask()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'status' => 200,
            'data'   => [
                'statuses' => TaskStatus::getValues(),
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionSaveTask()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            return ['status' => 400];
        }

        $form = new TaskEmployeesForm();
        $form->attributes = $data;

        if (!$form->validate()) {
            return [
                'status' => 400,
                'data'   => $form->getErrors(),
            ];
        }

        try {
            $taskService = new TaskService($data['id']);
            $task = $taskService->updateOrCreateTask($data);

            $updatedTask = Task::find()
                ->with('employeesTask', 'employeesTask.employee')
                ->where(['id' => $task->id])
                ->one();

            return [
                'status' => 200,
                'data'   => $task,
                // 'data'   => TaskTransformer::transform($updatedTask),
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 400,
                'data'   => $exception->getMessage(),
            ];
        }
    }
}
