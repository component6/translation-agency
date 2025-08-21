<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EmployeeTask $model */

$this->title = Yii::t('app', 'Create Employee Task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
