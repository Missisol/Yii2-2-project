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
            $projectManagerId = ProjectUser::find()->byProjectManager($project->id)
                ->select('user_id')->column();
            foreach ($projectManagerId as $id) {
                $manager = User::findOne($id);

                $this->triggerChangeTaskStatus($task, $user, $project, $manager, $message);
            }
        } else {
            $projectManagerId = ProjectUser::find()->byProjectManager($project->id)
                ->select('user_id')->column();
            foreach ($projectManagerId as $id) {
                $manager = User::findOne($id);

                $this->triggerChangeTaskStatus($task, $user, $project, $manager, $message);
            };

            $projectTesterId = ProjectUser::find()->byProjectTester($project->id)
                ->select('user_id')->column();
            foreach ($projectTesterId as $id) {
                $tester = User::findOne($id);

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
     * @return bool
     */
    public function takeTask(Task $task, User $user)
    {
        $model = Task::findOne($task->id);
        $model->started_at = mktime();
        $model->executor_id = $user->id;

        return $model->save();
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function completeTask(Task $task)
    {
        $model = Task::findOne($task->id);
        $model->completed_at = mktime();

        return $model->save();
    }

}