<?php
namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\RegexType;

class RegexTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCanValidate()
    {
        $config = [
            'pattern' => '/^goo+gle$/'
        ];
        $validator = new RegexType($config);

        $this->assertTrue($validator->isValid('gooooogle'));
        $this->assertfalse($validator->isValid('not google'));
    }
}