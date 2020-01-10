<?php

namespace Svycka\SettingsTest\Options\Factory;

use Svycka\Settings\Options\Factory\ModuleOptionsFactory;
use Svycka\Settings\Options\ModuleOptions;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ModuleOptionsFactoryTest extends \PHPUnit\Framework\TestCase
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
