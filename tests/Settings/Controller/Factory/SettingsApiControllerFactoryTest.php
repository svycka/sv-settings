<?php

namespace Svycka\SettingsTest\Controller\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Controller\Factory\SettingsApiControllerFactory;
use Svycka\Settings\Controller\SettingsApiController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsApiControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get(CollectionsManager::class)->willReturn(new CollectionsManager());
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator($serviceManager->reveal());

        $factory = new SettingsApiControllerFactory();
        $controller = $factory->createService($controllerManager);
        $this->assertInstanceOf(SettingsApiController::class, $controller);
    }
}
