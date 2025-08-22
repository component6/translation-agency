<?php

namespace console\controllers;

use common\enums\EmployeeStatus;
use common\enums\EmploymentType;
use common\enums\TaskStatus;
use common\models\Employee;
use common\models\Task;
use Faker\Factory as FakerFactory;
use Yii;
use yii\console\Controller;

class FillTestDataController extends Controller
{
    /**
     * php yii fill-test-data
     */
    public function actionIndex()
    {
        $this->truncateTables();
        $this->makeTasks();
        $this->makeEmployees();
    }

    private function truncateTables()
    {
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();

        Yii::$app->db->createCommand()->truncateTable('employees_tasks')->execute();
        Yii::$app->db->createCommand()->truncateTable('tasks')->execute();
        Yii::$app->db->createCommand()->truncateTable('employees')->execute();

        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
    }

    private function makeTasks()
    {
        $faker        = FakerFactory::create();
        $taskStatuses = TaskStatus::getAllowedValues();

        for ($i = 0; $i < 5; $i++) {
            $model         = new Task();
            $model->title  = "Task " . $faker->sentence(5, true);
            $model->status = $taskStatuses[array_rand($taskStatuses)];
            $model->save();

            if ($model->save()) {
                echo "Модель успешно создана" . PHP_EOL;
            } else {
                print_r($model->errors);
            }
        }
    }

    private function makeEmployees()
    {
        $faker            = FakerFactory::create();
        $employmentTypes  = EmploymentType::getAllowedValues();

        for ($i = 0; $i < 10; $i++) {
            $model                  = new Employee();
            $model->title           = $faker->name;
            $model->status          = EmployeeStatus::ACTIVE;
            $model->employment_type = $employmentTypes[array_rand($employmentTypes)];
            $model->save();

            if ($model->save()) {
                echo "Модель успешно создана" . PHP_EOL;
            } else {
                print_r($model->errors);
            }
        }
    }
}
