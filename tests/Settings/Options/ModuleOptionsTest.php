<?php

namespace Svycka\SettingsTest\Options;

use Svycka\Settings\Options\ModuleOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    /** @var ModuleOptions */
    private $options;

    public function setUp()
    {
        $this->options = new ModuleOptions();
    }

    public function testCanReturnDefaultValues()
    {
        $this->assertEquals([], $this->options->getTypes());
        $this->assertEquals([], $this->options->getSettingsManager());
        $this->assertEquals([], $this->options->getCollections());
    }

    public function testCanSetGetTypes()
    {
        $this->options->setTypes($value = [
            'invokables' => [
                \stdClass::class => \stdClass::class
            ]
        ]);
        $this->assertSame($value, $this->options->getTypes());
    }

    public function testCanSetGetCollections()
    {
        $this->options->setCollections($value = [
            'invokables' => [
                \stdClass::class => \stdClass::class
            ]
        ]);
        $this->assertSame($value, $this->options->getCollections());
    }

    public function testCanSetGetSettingsManager()
    {
        $this->options->setSettingsManager($value = [
            'invokables' => [
                \stdClass::class => \stdClass::class
            ]
        ]);
        $this->assertSame($value, $this->options->getSettingsManager());
    }
}
