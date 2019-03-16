<?php

use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?php if (!empty(ProjectUser::find()->andWhere(['user_id' => Yii::$app->user->id])
        ->andWhere(['role' => ProjectUser::ROLE_MANAGER])->column())) : ?>
      <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
  </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            [
                'attribute' => 'project_id',
                'label' => 'Project',
                'filter' => Project::find()->byUser(Yii::$app->user->id)
                    ->select('title')->indexBy('id')->column(),
                'content' => function (Task $model) {
                    $project_title = $model->project->title;
                    return Html::a($project_title, ['project/view', 'id' => $model->project->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'executor_id',
                'label' => 'Executor',
                'filter' => User::find()->onlyActive()->byDeveloper()->column(),
                'content' => function (Task $model) {
                    if ($model->executor) {
                        $executor = $model->executor->username;
                        return Html::a($executor, ['user/view', 'id' => $model->executor->id]);
                    } else return 'Executor not assigned';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'creator_id',
                'label' => 'Creator',
                'filter' => User::find()->onlyActive()->byManager()->column(),
                'content' => function (Task $model) {
                    $creator = $model->creator->username;
                    return Html::a($creator, ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take} {complete} {double}',
                'buttons' => [
                    'take' => function ($url, Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('log-in');
                        return Html::a($icon,
                            ['task/take-task', 'id' => $model->id],
                            ['data' => [
                                'confirm' => 'Do you want to take this task?',
                                'method' => 'post',
                            ],
                            ]);
                    },
                    'complete' => function ($url, Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('log-out');
                        return Html::a($icon,
                            ['task/complete-task', 'id' => $model->id],
                            ['data' => [
                                'confirm' => 'Do you want to complete this task?',
                                'method' => 'post',
                            ],
                            ]);
                    },
                ],
                'visibleButtons' => [
                    'update' => function (Task $model, $key, $index) {
                        return Yii::$app->taskService->canManager($model->project, Yii::$app->user->identity);
                    },
                    'delete' => function (Task $model, $key, $index) {
                        return Yii::$app->taskService->canManager($model->project, Yii::$app->user->identity);
                    },
                    'take' => function (Task $model, $key, $index) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'complete' => function (Task $model, $key, $index) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    },
                ],
            ],
        ],
    ])
    ?>
    <?php Pjax::end(); ?>
</div>
