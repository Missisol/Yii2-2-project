<?php

namespace frontend\modules\api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use frontend\modules\api\models\Task;

/**
 * Default controller for the `api` module
 */
class TaskController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Task::find(),
        ]);
    }

    public function actionView($id)
    {
        return Task::findOne($id);
    }
}
