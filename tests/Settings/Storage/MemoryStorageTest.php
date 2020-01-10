<?php

namespace Svycka\SettingsTest\Storage;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Storage\MemoryStorage;
use TestAssets\CustomCollection;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class MemoryStorageTest extends \PHPUnit\Framework\TestCase
{
    /** @var CollectionInterface */
    private $collection;

    public function setUp()
    {
        $this->collection = new CustomCollection();
    }

    public function testWillReturnNullValueIfNotSet()
    {
        $storage = new MemoryStorage();
        $this->assertNull($storage->get($this->collection, null, 'temperature_unit'));
    }

    public function testCanSetGetValue()
    {
        $storage = new MemoryStorage();
        $storage->set($this->collection, $identifier = 'user1', $name = 'temperature_unit', $value = 'F');
        $setting = $storage->get($this->collection, $identifier, 'temperature_unit');
        $this->assertInstanceOf($this->collection->getOptions()->getObjectClass(), $setting);
        $this->assertEquals($name, $setting->getName());
        $this->assertEquals($value, $setting->getValue());
        $this->assertEquals($identifier, $setting->getIdentifier());
        $this->assertEquals($this->collection->getOptions()->getName(), $setting->getCollection());
    }

    public function testCanGetEmptyList()
    {
        $storage = new MemoryStorage();
        $this->assertEquals([], $storage->getList($this->collection, null));
    }

    public function testCanGetList()
    {
        $storage = new MemoryStorage();
        $storage->set($this->collection, $identifier1 = 'user1', $name = 'temperature_unit', $value = 'F');
        $storage->set($this->collection, $identifier1 = 'user1', $name = 'distance_unit', $value = 'km');
        $storage->set($this->collection, $identifier2 = 'user2', $name = 'temperature_unit', $value = 'F');
        $this->assertCount(2, $storage->getList($this->collection, $identifier1));
        $this->assertCount(1, $storage->getList($this->collection, $identifier2));
    }
}
