<?php

use common\models\Project;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'content' => function (Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => Project::RELATION_PROJECT_USERS . '.role',
                'content' => function (Project $model) {
                    return join(', ', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'active',
                'filter' => Project::STATUS_PROJECT_LABELS,
                'content' => function (Project $model) {
                    return Project::STATUS_PROJECT_LABELS[$model->active];
                },
            ],
            'description:ntext',
            [
                'attribute' => 'creator_id',
                'content' => function (Project $model) {
                    return Html::a($model->creator->username,
                        ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'updater_id',
                'content' => function (Project $model) {
                    if ($model->updater) {
                        return Html::a($model->updater->username,
                            ['user/view', 'id' => $model->updater->id]);
                    } else return '-';
                },
                'format' => 'html',
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<div class="site-index">
    <?= \common\modules\chat\widgets\Chat::widget([
        'port' => 8081,
        'userName' => Yii::$app->user->identity->username,
        'userAvatar' => Yii::$app->user->identity
            ->getThumbUploadUrl('avatar', \common\models\User::AVATAR_THUMB),
    ]) ?>
</div>

