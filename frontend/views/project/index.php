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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'content' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => \common\models\Project::RELATION_PROJECT_USERS . '.role',
                'content' => function (\common\models\Project $model) {
                    return join(', ', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'active',
                'filter' => \common\models\Project::STATUS_PROJECT_LABELS,
                'content' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUS_PROJECT_LABELS[$model->active];
                },
            ],
            'description:ntext',
            [
                'attribute' => 'creator_id',
                'content' => function (\common\models\Project $model) {
                    return Html::a($model->creator->username,
                        ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'updater_id',
                'content' => function (\common\models\Project $model) {
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
