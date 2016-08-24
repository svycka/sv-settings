<?php

namespace Svycka\SettingsTest\Service\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Service\Factory\SettingsServiceFactory;
use Svycka\Settings\Service\SettingsService;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ContainerInterface::class);
        $serviceManager->get(CollectionsManager::class)->willReturn(new CollectionsManager(new ServiceManager()));

        $factory = new SettingsServiceFactory();
        $service = $factory($serviceManager->reveal());
        $this->assertInstanceOf(SettingsService::class, $service);
    }
}
