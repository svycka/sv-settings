<?php

namespace Svycka\SettingsTest\Options\Factory;

use Svycka\Settings\Options\Factory\ModuleOptionsFactory;
use Svycka\Settings\Options\ModuleOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get('config')
            ->willReturn([
                'sv-settings' => [
                    'collections' => [],
                    'types' => [],
                    'Settings_manager' => [],
                ]
            ]);

        $factory = new ModuleOptionsFactory();
        $options = $factory($serviceManager->reveal());
        $this->assertInstanceOf(ModuleOptions::class, $options);
    }
}
