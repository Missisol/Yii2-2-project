<?php

namespace common\services;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class TaskStatusEvent extends Event
{
    public $task;
    public $project;
    public $user;
    public $userWithRole;
    public $message;
}

class TaskService extends Component
{
    const EVENT_TASK = 'event_task';

    public function taskEventFunc(Task $task, User $user, Project $project, User $userWithRole, $message)
    {
        $event = new TaskStatusEvent();
        $event->task = $task;
        $event->project = $project;
        $event->user = $user;
        $event->userWithRole = $userWithRole;
        $event->message = $message;
        $this->trigger(self::EVENT_TASK, $event);
    }

    /**
     * @param Project $project
     * @param User $user
     * @return bool
     */
    public function canManager(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canTake(Task $task, User $user)
    {
        return (\Yii::$app->projectService
                ->hasRole($task->project, $user, ProjectUser::ROLE_DEVELOPER) &&
            ($task->executor_id === null));
    }

    /**
     * @param Task $task
     * @param User $user
     * @return bool
     */
    public function canComplete(Task $task, User $user)
    {
        return (($task->executor_id === $user->id) && ($task->completed_at === null));
    }

    /**
     * @param Task $task
     * @param User $user
     * @return Task
     */
    public function takeTask(Task $task, User $user)
    {
        $task->started_at = mktime();
        $task->executor_id = $user->id;
        return $task;
    }

    /**
     * @param Task $task
     * @return Task
     */
    public function completeTask(Task $task)
    {
        $task->completed_at = mktime();
        return $task;
    }

}