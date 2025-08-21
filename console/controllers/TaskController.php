<?php

namespace console\controllers;

use common\enums\TaskStatus;
use common\models\Task;
use Faker\Factory as FakerFactory;
use yii\console\Controller;

class TaskController extends Controller
{
    /**
     * php yii task/create-fake
     */
    public function actionCreateFake()
    {
        $faker        = FakerFactory::create();
        $taskStatuses = TaskStatus::getAllowedValues();

        $model         = new Task();
        $model->title  = $faker->sentence(5, true);
        $model->status = $taskStatuses[array_rand($taskStatuses)];
        $model->save();

        if ($model->save()) {
            echo "Модель успешно создана" . PHP_EOL;
        } else {
            print_r($model->errors);
        }
    }
}
