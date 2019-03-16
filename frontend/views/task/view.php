<?php

use common\models\ProjectUser;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?php if (!empty(ProjectUser::find()->andWhere(['user_id' => Yii::$app->user->id])
          ->andWhere(['role' => ProjectUser::ROLE_MANAGER])->column())) : ?>
          <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Delete', ['delete', 'id' => $model->id], [
              'class' => 'btn btn-danger',
              'data' => [
                  'confirm' => 'Are you sure you want to take this task?',
                  'method' => 'post',
              ],
          ]) ?>
      <?php endif; ?>
      <?php if (!empty(ProjectUser::find()->andWhere(['user_id' => Yii::$app->user->id])
          ->andWhere(['role' => ProjectUser::ROLE_DEVELOPER])->column())) : ?>
          <?php if (Yii::$app->taskService->canTake($model, Yii::$app->user->identity)) : ?>
              <?= Html::a('Take', ['task/take-task', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
          <?php endif; ?>
          <?php if (Yii::$app->taskService->canComplete($model, Yii::$app->user->identity)) : ?>
              <?= Html::a('Complete', ['task/complete-task', 'id' => $model->id], [
                  'class' => 'btn btn-danger',
                  'data' => [
                      'confirm' => 'Are you sure you want to complete this task?',
                      'method' => 'post',
                  ],
              ]) ?>
          <?php endif; ?>
      <?php endif; ?>
  </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Project title' => 'project.title',
            'title',
            'description:ntext',
            'executor.username',
            'started_at:datetime',
            'completed_at:datetime',
            'creator.username',
            'updater.username',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
