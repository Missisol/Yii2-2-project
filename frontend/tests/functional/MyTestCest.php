<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class MyTestCest
{
    public function _before(FunctionalTester $I)
    {
    }

  /**
   * @dataProvider pageProvider
   */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data)
    {
      $I->amOnRoute($data['url']);
      $I->see($data['label'], 'li.active > a');
    }

    protected function pageProvider()
    {
      return [
        ['url' => "site/index", 'label' => "Home"],
        ['url' => "site/about", 'label' => "About"],
        ['url' => "site/contact", 'label' => "Contact"],
        ['url' => "site/signup", 'label' => "Signup"],
        ['url' => "site/login", 'label' => "Login"],
      ];
    }
}
