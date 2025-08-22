<?php

namespace backend\modules\api\controllers;

use common\enums\EmployeeStatus;
use common\enums\EmploymentType;
use common\models\Employee;
use yii\web\Controller;

class EmployeeController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionEmployees()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $response = ['status' => 400];

        $employees = Employee::find()->scopeStatuses()->all();

        if (!empty($employees)) {
            $response = [
                'status' => 200,
                'data'   => $employees,
            ];
        }

        return $response;
    }

    /**
     * @return string
     */
    public function actionFieldsEmployee()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'status' => 200,
            'data'   => [
                'statuses' => EmployeeStatus::getValues(),
                'types'    => EmploymentType::getValues(),
            ],
        ];
    }
}
