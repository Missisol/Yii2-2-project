<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use \common\models\ProjectUser;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ]) ?>
  </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'label' => 'Active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_PROJECT_LABELS[$model->active];
                }
            ],
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'User name',
                'attribute' => 'title',
                'content' => function (ProjectUser $model) {
                    $user = $model->user->username;

                    return $user;
                }
            ],
            [
                'label' => 'User role',
                'attribute' => 'title',
                'content' => function (ProjectUser $model) {
                    $role = $model->role;

                    return $role;
                }
            ],
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
