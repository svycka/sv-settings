<?php

namespace Svycka\SettingsTest;

use Svycka\Settings\Module;

class ModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigIsArray()
    {
        $module = new Module();
        $this->assertInternalType('array', $module->getConfig());
    }
}
