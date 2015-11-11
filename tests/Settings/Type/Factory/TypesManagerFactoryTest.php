<?php

namespace Svycka\SettingsTest\Type\Factory;

use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Type\Factory\TypesManagerFactory;
use Svycka\Settings\Type\TypesManager;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get(ModuleOptions::class)->willReturn(new ModuleOptions);

        $factory = new TypesManagerFactory();
        $manager = $factory->createService($serviceManager->reveal());
        $this->assertInstanceOf(TypesManager::class, $manager);
    }
}