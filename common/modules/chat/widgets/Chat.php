<?php

namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
  public $port = 8080;
  public $userName = 'user';
  public $userAvatar = 'avatar';
  public $urlApi = 'urlApi';

  public function init()
  {
  }

  public function run()
  {
    $this->view->registerJsVar('wsPort', $this->port);
    $this->view->registerJsVar('userName', $this->userName);
    $this->view->registerJsVar('userAvatar', $this->userAvatar);
    $this->view->registerJsVar('urlApi', $this->urlApi);

    ChatAsset::register($this->view);
    return $this->render('chat');
  }
}