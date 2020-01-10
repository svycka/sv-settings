<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\IntegerType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class IntegerTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testCanValidate()
    {
        $validator = new IntegerType();

        $this->assertTrue($validator->isValid('100'));
        $this->assertFalse($validator->isValid('10.1'));
        $this->assertFalse($validator->isValid('test'));
    }
}
