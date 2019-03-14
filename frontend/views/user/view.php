<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <?= Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_AVERAGE)) ?>

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a('Update', ['profile', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
  </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'label' => 'status',
                'value' => \common\models\User::STATUS_LABELS[$model->status],
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
