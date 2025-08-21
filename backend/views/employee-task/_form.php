<?php

use common\models\Employee;
use common\models\Task;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EmployeeTask $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employee-task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(Employee::find()->all(), 'id', 'title'),
        ['prompt' => 'Select']
    ) ?>

    <?= $form->field($model, 'task_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(Task::find()->all(), 'id', 'title'),
        ['prompt' => 'Select']
    ) ?>

    <?php // = $form->field($model, 'created_at')->textInput() ?>

    <?php // = $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
