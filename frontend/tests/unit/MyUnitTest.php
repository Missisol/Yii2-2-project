<?php namespace frontend\tests;

use frontend\models\ContactForm;

class MyUnitTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
      $var = 6;
      $arr = [
        'one' => 1,
        'two' => 5,
        'three' => 7,
      ];
      $name = [
        0 => 'Vasya',
        1 => 'xxx',
        2 => 'yyy',
      ];
      $email = 'vvv@vvv';
      $model = new ContactForm();
      $model->setAttributes([
        'name' => $name,
        'email' => $email,
      ]);
      $username = [
        0 => 'Vasya',
        1 => 'xxx',
        2 => 'yyy',
      ];

      $this->assertTrue(!empty($var), 'Comparison with true, checking whether a variable is empty');
      expect(is_array($arr))->true();

      $this->assertEquals($var, 6, 'assertEquals');

      $this->assertLessThan($arr['two'], 2, 'assertLessThen');

      $this->assertAttributeEquals($username, 'name', $model);
      expect($email, $model->email)->equals('vvv@vvv');

      $this->assertArrayHasKey('two', $arr, 'Checking whether a key is an array');
    }
}