<?php

namespace common\models\query;

use common\models\User;
use common\models\ProjectUser;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @return UserQuery
     */
    public function onlyActive()
    {
        return User::find()->select('username')->indexBy('id')
            ->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * Query for users with manager role
     * @return UserQuery
     */
    public function byManager() {
        $query = ProjectUser::find()->byManager()->select('user_id');
        return $this->andWhere(['id' => $query]);
    }

    /**
     * Query for users with developer role
     * @return UserQuery
     */
    public function byDeveloper() {
        $query = ProjectUser::find()->byDeveloper()->select('user_id');
        return $this->andWhere(['id' => $query]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
