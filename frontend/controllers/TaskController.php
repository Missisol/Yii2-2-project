<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        /* @var $query TaskQuery */
        $query = $dataProvider->query;
        $query->byUser(Yii::$app->user->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (empty(ProjectUser::find()->byUserManager(Yii::$app->user->id)->column())) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (empty(ProjectUser::find()->byUserManager(Yii::$app->user->id)->column())) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (empty(ProjectUser::find()->byUserManager(Yii::$app->user->id)->column())) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);
        $message = 'taken to work';

        if (Yii::$app->taskService->takeTask($model, Yii::$app->user->identity)) {
            Yii::$app->taskService->sendToUserWithRole($model, User::findOne(Yii::$app->user->id),
                Project::findOne($model->project_id), $message);

            Yii::$app->session->setFlash('success', 'Executor assigned');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);
        $message = 'completed';

        if (Yii::$app->taskService->completeTask($model)) {
            Yii::$app->taskService->sendToUserWithRole($model, User::findOne(Yii::$app->user->id),
                Project::findOne($model->project_id), $message);

            Yii::$app->session->setFlash('success', 'Task completed');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
