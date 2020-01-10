<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\FloatType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class FloatTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testCanValidate()
    {
        $validator = new FloatType();

        $this->assertTrue($validator->isValid('100'));
        $this->assertTrue($validator->isValid('10.1'));
        $this->assertTrue($validator->isValid(0.0));
        $this->assertFalse($validator->isValid(''));
        $this->assertFalse($validator->isValid('test'));
    }
}
