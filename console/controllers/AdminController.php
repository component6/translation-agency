<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;

class AdminController extends Controller
{
    /**
     * php yii admin/create
     */
    public function actionCreate()
    {
        $user           = new User();
        $user->username = 'admin';
        $user->email    = 'admin@example.com';
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->status = USer::STATUS_ACTIVE;
        
        if ($user->save()) {
            echo "Модель успешно создана" . PHP_EOL;
        } else {
            print_r($user->errors);
        }
    }
}
