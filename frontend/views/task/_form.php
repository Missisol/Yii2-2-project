<?php

use common\models\Project;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],

    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'project_id')
        ->dropDownList(Project::find()->select('title')
            ->where(['active' => Project::STATUS_PROJECT_ACTIVE])->column()) ?>


  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
  </div>

    <?php ActiveForm::end(); ?>

</div>
