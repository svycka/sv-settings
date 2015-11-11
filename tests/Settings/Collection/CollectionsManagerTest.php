<?php

namespace Svycka\SettingsTest\Collection;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Type\TypesManager;
use TestAssets\CustomCollection;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanAddCustomType()
    {
        $config = new Config(['invokables' => [
            'custom_collection' => CustomCollection::class,
        ]]);
        $manager = new CollectionsManager($config);

        $this->assertTrue($manager->has('custom_collection'));
        $this->assertTrue($manager->has(CustomCollection::class));
        $this->assertInstanceOf(CustomCollection::class, $manager->get('custom_collection'));
    }

    public function testDoesNotAllowInvalidTypes()
    {
        $config = new Config([
            'invokables' => [
                'invalid_collection' => \stdClass::class,
            ]
        ]);
        $manager = new CollectionsManager($config);

        $this->setExpectedException(RuntimeException::class);
        $manager->get('invalid_collection');
    }

    public function testThrowExceptionIfNotExist()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $serviceLocator->get(ModuleOptions::class)->willReturn(new ModuleOptions());
        $serviceLocator->has('not_exist')->willReturn(false);

        $manager = new CollectionsManager();
        $manager->setServiceLocator($serviceLocator->reveal());

        $this->setExpectedException(
            ServiceNotFoundException::class,
            sprintf('%s::get was unable to fetch or create an instance for not_exist', CollectionsManager::class)
        );
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

        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $serviceLocator->get(ModuleOptions::class)->willReturn($moduleOptions);
        $serviceLocator->get(MemoryStorage::class)->willReturn(new MemoryStorage);
        $serviceLocator->get(NullProvider::class)->willReturn(new NullProvider);
        $serviceLocator->get(TypesManager::class)->willReturn(new TypesManager());
        $serviceLocator->has('custom-settings')->willReturn(false);

        $manager = new CollectionsManager();
        $manager->setServiceLocator($serviceLocator->reveal());

        $collection = $manager->get('custom-settings');
        $this->assertInstanceOf(SettingsCollection::class, $collection);
        $this->assertEquals(123, $collection->getValue('number'));
    }
}
