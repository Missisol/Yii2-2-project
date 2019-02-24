<?php

namespace common\modules\chat\controllers;

use common\modules\chat\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
      $server = IoServer::factory(
        new HttpServer(
          new WsServer(
            new Chat()
          )
        ),
        8080
      );

      echo 'server has been started';

      $server->run();
    }
}
