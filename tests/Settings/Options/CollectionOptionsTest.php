<?php

namespace Svycka\SettingsTest\Options;

use Svycka\Settings\Entity\Setting;
use Svycka\Settings\Options\CollectionOptions;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Storage\MemoryStorage;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionOptionsTest extends \PHPUnit_Framework_TestCase
{
    /** @var CollectionOptions */
    private $options;

    public function setUp()
    {
        $this->options = new CollectionOptions();
    }

    public function testCanReturnDefaultValues()
    {
        $this->assertEquals(NullProvider::class, $this->options->getOwnerProvider());
        $this->assertEquals(Setting::class, $this->options->getObjectClass());
    }

    public function testCanSetGetName()
    {
        $this->options->setName($value = 'name');
        $this->assertSame($value, $this->options->getName());
    }

    public function testCanSetGetObjectClass()
    {
        $this->options->setObjectClass($value = Setting::class);
        $this->assertSame($value, $this->options->getObjectClass());
    }

    public function testCanSetGetOwnerProvider()
    {
        $this->options->setOwnerProvider($value = NullProvider::class);
        $this->assertSame($value, $this->options->getOwnerProvider());
    }

    public function testCanSetGetStorageAdapter()
    {
        $this->options->setStorageAdapter($value = MemoryStorage::class);
        $this->assertSame($value, $this->options->getStorageAdapter());
    }

    public function testCanSetGetSettings()
    {
        $this->options->setSettings($value = ['settings']);
        $this->assertSame($value, $this->options->getSettings());
    }
}
