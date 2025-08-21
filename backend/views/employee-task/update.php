<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EmployeeTask $model */

$this->title = Yii::t('app', 'Update Employee Task: {name}', [
    'name' => $model->employee_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employee_id, 'url' => ['view', 'employee_id' => $model->employee_id, 'task_id' => $model->task_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="employee-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
