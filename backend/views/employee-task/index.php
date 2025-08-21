<?php

use common\models\Employee;
use common\models\EmployeeTask;
use common\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\EmployeeTaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Employee Tasks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Employee Task'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'employee_id',
                'value' => function ($model) {
                    return $model->employee ? $model->employee->title : '';
                },
                'filter' => \yii\helpers\ArrayHelper::map(Employee::find()->all(), 'id', 'title'),
            ],
            [
            'attribute' => 'task_id',
                'value' => function ($model) {
                    return $model->task ? $model->task->title : '';
                },
                'filter' => \yii\helpers\ArrayHelper::map(Task::find()->all(), 'id', 'title'),
            ],
            // 'created_at',
            // 'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, EmployeeTask $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'employee_id' => $model->employee_id, 'task_id' => $model->task_id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
