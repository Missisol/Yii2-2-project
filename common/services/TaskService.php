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
    const EVENT_CHANGE_TASK_STATUS = 'event_change_task_status';

    /**
     * @param Task $task
     * @param User $user
     * @param Project $project
     * @param $userWithRole
     * @param $message
     */
    public function triggerChangeTaskStatus(Task $task, User $user, Project $project, $userWithRole, $message)
    {
        $event = new TaskStatusEvent();
        $event->task = $task;
        $event->project = $project;
        $event->user = $user;
        $event->userWithRole = $userWithRole;
        $event->message = $message;
        $this->trigger(self::EVENT_CHANGE_TASK_STATUS, $event);
    }

    /**
     * @param Task $task
     * @param User $user
     * @param Project $project
     * @param $message
     */
    public function sendToUserWithRole(Task $task, User $user, Project $project, $message)
    {

        if ($message == 'taken to work') {
            $managers = ProjectUser::find()->where(['project_id' => $project->id])
                ->andWhere(['role' => ProjectUser::ROLE_MANAGER])->column();
            foreach ($managers as $id) {
                $manager = User::findOne(ProjectUser::findOne($id)->user_id);

                $this->triggerChangeTaskStatus($task, $user, $project, $manager, $message);
            }
        } else {
            $managers = ProjectUser::find()->where(['project_id' => $project->id])
                ->andWhere(['role' => ProjectUser::ROLE_MANAGER])->column();
            foreach ($managers as $id) {
                $manager = User::findOne(ProjectUser::findOne($id)->user_id);

                $this->triggerChangeTaskStatus($task, $user, $project, $manager, $message);
            };

            $tester = ProjectUser::find()->where(['project_id' => $project->id])
                ->andWhere(['role' => ProjectUser::ROLE_TESTER])->column();
            foreach ($tester as $id) {
                $tester = User::findOne(ProjectUser::findOne($id)->user_id);

                $this->triggerChangeTaskStatus($task, $user, $project, $tester, $message);
            }
        }
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