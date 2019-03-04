<?php

namespace frontend\modules\api\models;

use Yii;
use common\models\User;
use common\models\ProjectUser;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $active
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creator
 * @property User $updater
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 */
class Project extends \common\models\Project
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
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
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
            },
            'active',
        ];
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS];
    }
}
