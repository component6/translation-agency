<?php

namespace console\controllers;

use common\enums\EmployeeStatus;
use common\enums\EmploymentType;
use common\models\Employee;
use Faker\Factory as FakerFactory;
use yii\console\Controller;

class EmployeeController extends Controller
{
    /**
     * php yii employee/create-fake
     */
    public function actionCreateFake()
    {
        $faker            = FakerFactory::create();
        $employeeStatuses = EmployeeStatus::getAllowedValues();
        $employmentTypes  = EmploymentType::getAllowedValues();

        $model                  = new Employee();
        $model->title           = $faker->name;
        $model->status          = $employeeStatuses[array_rand($employeeStatuses)];
        $model->employment_type = $employmentTypes[array_rand($employmentTypes)];
        $model->save();

        if ($model->save()) {
            echo "Модель успешно создана" . PHP_EOL;
        } else {
            print_r($model->errors);
        }
    }
}
