<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'App');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div id="app"></div>
</div>
