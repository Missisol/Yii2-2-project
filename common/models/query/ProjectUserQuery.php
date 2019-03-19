<?php

namespace common\models\query;

use common\models\ProjectUser;

/**
 * This is the ActiveQuery class for [[\common\models\ProjectUser]].
 *
 * @see \common\models\ProjectUser
 */
class ProjectUserQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $userId
     * @param null $role
     * @return $this
     */
    public function byUser($userId, $role = null)
    {
        $this->andWhere(['user_id' => $userId]);
        if ($role) {
            $this->andWhere(['role' => $role]);
        }
        return $this;
    }

    /**
     * @return ProjectUserQuery
     */
    public function byManager()
    {
        return $this->andWhere(['role' => ProjectUser::ROLE_MANAGER]);
    }

    /**
     * @return ProjectUserQuery
     */
    public function byDeveloper()
    {
        return $this->andWhere(['role' => ProjectUser::ROLE_DEVELOPER]);
    }

    /**
     * @param $projectId
     * @return ProjectUserQuery
     */
    public function byProjectManager($projectId)
    {
        return $this->andWhere(['role' => ProjectUser::ROLE_MANAGER])
            ->andWhere(['project_id' => $projectId]);
    }

    /**
     * @param $projectId
     * @return ProjectUserQuery
     */
    public function byProjectTester($projectId)
    {
        return $this->andWhere(['role' => ProjectUser::ROLE_TESTER])
            ->andWhere(['project_id' => $projectId]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ProjectUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
