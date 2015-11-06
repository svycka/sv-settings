<?php
namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\InArrayType;

class InArrayTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCanValidate()
    {
        $config = [
            'haystack' => [
                'one', 'two',
            ],
        ];
        $validator = new InArrayType($config);

        $this->assertTrue($validator->isValid('one'));
        $this->assertfalse($validator->isValid('three'));
    }
}