<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

  <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
      <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'filter' => \common\models\Project::STATUS_PROJECT_LABELS,
                'content' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_PROJECT_LABELS[$model->active];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<div class="site-index">
    <?= \common\modules\chat\widgets\Chat::widget([
        'port' => 8081,
        'userName' => Yii::$app->user->identity->username,
        'urlApi' => 'http://y2aa-backend.test/api/project',
        'userAvatar' => Yii::$app->user->identity
            ->getThumbUploadUrl('avatar', \common\models\User::AVATAR_THUMB),
    ]) ?>
</div>
