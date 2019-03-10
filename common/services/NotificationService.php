<?php

namespace common\services;

use Yii;
use yii\base\Component;


class NotificationService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    /**
     * @param $user
     * @param $project
     * @param $role
     */
    public function sendToUserAboutNewRole($user, $project, $role) {
        // Yii::info($e->dump(), '_');
        $views = ['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        Yii::$app->emailService->send($user->email, 'New role ' . $role, $views, $data);

    }
}