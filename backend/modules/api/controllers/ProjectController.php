<?php

namespace backend\modules\api\controllers;

use backend\modules\api\models\Project;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class ProjectController extends ActiveController
{
  public $modelClass = Project::class;
}
