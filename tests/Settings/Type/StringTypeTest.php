<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\StringType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class StringTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCanValidate()
    {
        $validator = new StringType([
            'min' => 3,
            'max' => 5
        ]);

        $this->assertTrue($validator->isValid('100'));
        $this->assertTrue($validator->isValid('test'));

        $this->assertFalse($validator->isValid(0));
        $this->assertFalse($validator->isValid(''));
        $this->assertfalse($validator->isValid('aa'));
        $this->assertfalse($validator->isValid('123456'));
    }
}
