<?php

namespace backend\modules\api\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $project_id
 * @property int $executor_id
 * @property int $started_at
 * @property int $completed_at
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creator
 * @property User $executor
 * @property User $updater
 * @property Project $project
 */
class Task extends \common\models\Task
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function ($model) {
                return mb_strimwidth($model->description, 0, 50, "");
            }
        ];
    }

    /**
     * @return array|false
     */
    public function extraFields()
    {
        return [self::RELATION_PROJECT];
    }
}
