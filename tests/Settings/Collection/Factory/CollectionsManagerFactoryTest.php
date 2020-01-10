<?php

namespace Svycka\SettingsTest\Collection\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\Factory\CollectionsManagerFactory;
use Svycka\Settings\Options\ModuleOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManagerFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ContainerInterface::class);
        $serviceManager->get(ModuleOptions::class)->willReturn(new ModuleOptions);

        $factory = new CollectionsManagerFactory();
        $manager = $factory($serviceManager->reveal());
        $this->assertInstanceOf(CollectionsManager::class, $manager);
    }
}
