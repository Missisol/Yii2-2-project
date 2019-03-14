<?php

namespace common\services;


use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class TaskService extends Component
{
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