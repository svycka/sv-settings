<?php

namespace Svycka\SettingsTest\Settings;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Service\SettingsService;
use TestAssets\CustomCollection;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var SettingsService */
    private $service;

    public function setUp()
    {
        $config = ['invokables' => [
            'my_collection' => CustomCollection::class,
        ]];
        $manager = new CollectionsManager(new ServiceManager(), $config);
        $this->service = new SettingsService($manager);
    }

    public function testCanGetCollection()
    {
        $this->assertInstanceOf(CollectionInterface::class, $this->service->getCollection('my_collection'));
    }

    public function testCanSetGetValue()
    {
        $this->service->setValue('my_collection', 'temperature_unit', $value = 'F');
        $this->assertSame($value, $this->service->getValue('my_collection', 'temperature_unit'));
    }

    public function testCanValidateValue()
    {
        $this->assertTrue($this->service->isValid('my_collection', 'distance_unit', 'm'));
        $this->assertFalse($this->service->isValid('my_collection', 'distance_unit', 'invalid'));
    }
}
