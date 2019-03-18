<?php

namespace common\services;

use Yii;
use yii\base\Component;


class NotificationService extends Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';
    const EVENT_TAKE_TASK = 'event_take_task';

    /**
     * @param $user
     * @param $project
     * @param $role
     */
    public function sendToUserAboutNewRole($user, $project, $role)
    {
        // Yii::info($e->dump(), '_');
        $views = ['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        Yii::$app->emailService->send($user->email, 'New role ' . $role, $views, $data);
    }

    /**
     * @param $task
     * @param $project
     * @param $user
     * @param $userWithRole
     * @param $message
     */
    public function sendToManagerAboutTaskStatus($task, $project, $user, $userWithRole, $message)
    {
        $views = ['html' => 'aboutTaskStatus-html', 'text' => 'aboutTaskStatus-text'];
        $data = [
            'user' => $user,
            'project' => $project,
            'task' => $task,
            'userWithRole' => $userWithRole,
            'message' => $message,
            ];
        Yii::$app->emailService->send($userWithRole->email, 'Task'.$task->id.' '.$message, $views, $data);
    }
}