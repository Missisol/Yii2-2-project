<?php

use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
/* @var $users[] An array of strings */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['label' => 'col-sm-2',]
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUS_PROJECT_LABELS) ?>

    <?php if (!$model->isNewRecord) { ?>
        <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)
            // https://github.com/unclead/yii2-multiple-input
            ->widget(MultipleInput::className(), [
                'id' => 'project-users-widget',
                'max' => 10,
                'min' => 0,
                'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
                'columns' => [
                    [
                        'name' => 'project_id',
                        'type' => 'hiddenInput',
                        'defaultValue' => $model->id,
                    ],
                    [
                        'name' => 'user_id',
                        'type' => 'dropDownList',
                        'title' => 'User',
                        'items' => $users,
                    ],
                    [
                        'name' => 'role',
                        'type' => 'dropDownList',
                        'title' => 'Role',
                        'items' => \common\models\ProjectUser::ROLE_LABELS,
                    ],
                ],
            ]);
        ?>
    <?php } ?>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
  </div>

    <?php ActiveForm::end(); ?>

</div>
