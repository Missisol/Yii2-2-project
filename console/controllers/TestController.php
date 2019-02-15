<?php
namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;

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
    $this->stdout('Hello, world!' . PHP_EOL);
    return ExitCode::OK;
  }
}
