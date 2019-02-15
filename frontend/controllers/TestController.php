<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Test controller
 */
class TestController extends Controller
{

  /**
   * Displays homepage.
   *
   * @return mixed
   */
  public function actionIndex()
  {
    return $this->renderContent('Hello, world!');
  }
}
