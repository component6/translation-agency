<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\EmployeeTask $model */

$this->title = $model->employee_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employee-task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'employee_id' => $model->employee_id, 'task_id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'employee_id' => $model->employee_id, 'task_id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'employee_id',
                'value' => $model->employee->title ?? null,
            ],
            [
                'attribute' => 'task_id',
                'value' => $model->task->title ?? null,
            ],
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
