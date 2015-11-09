<?php

namespace Svycka\SettingsTest\Collection\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\Factory\CollectionsManagerFactory;
use Svycka\Settings\Options\ModuleOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get(ModuleOptions::class)->willReturn(new ModuleOptions);

        $factory = new CollectionsManagerFactory();
        $manager = $factory->createService($serviceManager->reveal());
        $this->assertInstanceOf(CollectionsManager::class, $manager);
    }
}