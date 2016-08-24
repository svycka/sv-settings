<?php

namespace Svycka\SettingsTest\Collection;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Type\TypesManager;
use TestAssets\CustomCollection;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanAddCustomType()
    {
        $config = [
            'factories' => [
                CustomCollection::class => InvokableFactory::class,
            ],
            'aliases' => [
                'custom_collection' => CustomCollection::class,
            ],
        ];
        $manager = new CollectionsManager(new ServiceManager(), $config);

        $this->assertTrue($manager->has('custom_collection'));
        $this->assertTrue($manager->has(CustomCollection::class));
        $this->assertInstanceOf(CustomCollection::class, $manager->get('custom_collection'));
    }

    public function testDoesNotAllowInvalidTypes()
    {
        $config = [
            'factories' => [
                \stdClass::class => InvokableFactory::class,
            ],
            'aliases' => [
                'invalid_collection' => \stdClass::class,
            ],
        ];
        $manager = new CollectionsManager(new ServiceManager(), $config);

        $this->setExpectedException(InvalidServiceException::class);
        $manager->get('invalid_collection');
    }

    public function testThrowExceptionIfNotExist()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(ModuleOptions::class)->willReturn(new ModuleOptions());
        $container->has('not_exist')->willReturn(false);

        $manager = new CollectionsManager($container->reveal());

        $this->setExpectedException(ServiceNotFoundException::class);
        $manager->get('not_exist');
    }

    public function testCanGetCollectionFromAbstractFactory()
    {
        $moduleOptions = new ModuleOptions();
        $moduleOptions->setCollections([
            'custom-settings' => [
                'storage_adapter' => MemoryStorage::class,
                'owner_provider'  => NullProvider::class,
                'settings' => [
                    'number' => [
                        'default_value' => 123,
                        'type'          => 'integer',
                    ],
                ],
            ]
        ]);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get(ModuleOptions::class)->willReturn($moduleOptions);
        $container->get(MemoryStorage::class)->willReturn(new MemoryStorage);
        $container->get(NullProvider::class)->willReturn(new NullProvider);
        $container->get(TypesManager::class)->willReturn(new TypesManager(new ServiceManager()));
        $container->has('custom-settings')->willReturn(false);

        $manager = new CollectionsManager($container->reveal());

        $collection = $manager->get('custom-settings');
        $this->assertInstanceOf(SettingsCollection::class, $collection);
        $this->assertEquals(123, $collection->getValue('number'));
    }
}
