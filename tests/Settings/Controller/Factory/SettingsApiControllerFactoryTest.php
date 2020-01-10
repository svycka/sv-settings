<?php

namespace Svycka\SettingsTest\Controller\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Controller\Factory\SettingsApiControllerFactory;
use Svycka\Settings\Controller\SettingsApiController;
use Laminas\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsApiControllerFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ContainerInterface::class);
        $serviceManager->get(CollectionsManager::class)->willReturn(new CollectionsManager(new ServiceManager()));

        $factory = new SettingsApiControllerFactory();
        $controller = $factory($serviceManager->reveal(), SettingsApiController::class);
        $this->assertInstanceOf(SettingsApiController::class, $controller);
    }
}
