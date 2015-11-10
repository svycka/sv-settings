<?php

namespace Svycka\SettingsTest\Service\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Service\Factory\SettingsServiceFactory;
use Svycka\Settings\Service\SettingsService;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get(CollectionsManager::class)->willReturn(new CollectionsManager());

        $factory = new SettingsServiceFactory();
        $service = $factory->createService($serviceManager->reveal());
        $this->assertInstanceOf(SettingsService::class, $service);
    }
}