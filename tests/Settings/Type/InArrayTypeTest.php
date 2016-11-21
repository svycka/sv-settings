<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\InArrayType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
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
        $this->assertFalse($validator->isValid('three'));
    }
}
