<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userWithRole common\models\User*/
/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $task \common\models\Task */
/* @var $message */

?>
<div>
  <p>Hello <?= Html::encode($userWithRole->username) ?>,</p>

  <p>task <?= $task->title ?> in the project <?= $project->title ?>
       <?= $message ?> by user <?= $user->username ?></p>
</div>
