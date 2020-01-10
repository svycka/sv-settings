<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\RegexType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class RegexTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testCanValidate()
    {
        $config = [
            'pattern' => '/^goo+gle$/'
        ];
        $validator = new RegexType($config);

        $this->assertTrue($validator->isValid('gooooogle'));
        $this->assertFalse($validator->isValid('not google'));
    }
}
