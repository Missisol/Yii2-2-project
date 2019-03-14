<?php

namespace common\models\query;

use common\models\User;

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
