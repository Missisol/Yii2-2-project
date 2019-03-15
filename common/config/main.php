<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class,
        ],
        'notificationService' => [
            'class' => \common\services\NotificationService::class,
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            'on ' . \common\services\ProjectService::EVENT_ASSIGN_ROLE =>
                function (\common\services\AssignRoleEvent $e) {
                    Yii::$app->notificationService->sendToUserAboutNewRole($e->user, $e->project, $e->role);
                }
        ],
        'taskService' => [
            'class' => \common\services\TaskService::class,
            'on ' . \common\services\TaskService::EVENT_TASK =>
                function (\common\services\TaskStatusEvent $e) {
                    Yii::$app->notificationService
                        ->sendToManagerAboutTaskStatus($e->task, $e->project, $e->user, $e->userWithRole, $e->message);
                }
        ]
    ],
    'modules' => [
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
    ],
];
