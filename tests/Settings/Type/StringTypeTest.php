<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\StringType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class StringTypeTest extends \PHPUnit\Framework\TestCase
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
        $this->assertFalse($validator->isValid('aa'));
        $this->assertFalse($validator->isValid('123456'));
    }
}
