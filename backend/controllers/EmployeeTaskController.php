<?php

namespace backend\controllers;

use common\models\EmployeeTask;
use common\models\EmployeeTaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeTaskController implements the CRUD actions for EmployeeTask model.
 */
class EmployeeTaskController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all EmployeeTask models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeTaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeTask model.
     * @param int $employee_id Employee ID
     * @param int $task_id Task ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($employee_id, $task_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($employee_id, $task_id),
        ]);
    }

    /**
     * Creates a new EmployeeTask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EmployeeTask();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'employee_id' => $model->employee_id, 'task_id' => $model->task_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmployeeTask model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $employee_id Employee ID
     * @param int $task_id Task ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($employee_id, $task_id)
    {
        $model = $this->findModel($employee_id, $task_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'employee_id' => $model->employee_id, 'task_id' => $model->task_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmployeeTask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $employee_id Employee ID
     * @param int $task_id Task ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($employee_id, $task_id)
    {
        $this->findModel($employee_id, $task_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmployeeTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $employee_id Employee ID
     * @param int $task_id Task ID
     * @return EmployeeTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($employee_id, $task_id)
    {
        if (($model = EmployeeTask::findOne(['employee_id' => $employee_id, 'task_id' => $task_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
