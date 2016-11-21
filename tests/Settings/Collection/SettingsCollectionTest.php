<?php

namespace Svycka\SettingsTest\Collection;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Exception\RuntimeException;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use Svycka\Settings\Options\CollectionOptionsInterface;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Type\TypesManager;
use TestAssets\UserCollectionOptions;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CollectionInterface
     */
    private $collection;

    public function setUp()
    {
        $this->collection = new SettingsCollection(
            new UserCollectionOptions(),
            new MemoryStorage(),
            new NullProvider(),
            new TypesManager(new ServiceManager())
        );
    }

    public function testConstructorCanCreateCollectionWithInterfaces()
    {
        /** @var CollectionOptionsInterface $options */
        $options = $this->prophesize(CollectionOptionsInterface::class)->reveal();
        /** @var StorageAdapterInterface $adapter */
        $adapter = $this->prophesize(StorageAdapterInterface::class)->reveal();
        /** @var OwnerProviderInterface $owner_provider */
        $owner_provider = $this->prophesize(OwnerProviderInterface::class)->reveal();
        /** @var TypesManager $types_manager */
        $types_manager = new TypesManager(new ServiceManager(), []);

        new SettingsCollection($options, $adapter, $owner_provider, $types_manager);
    }

    public function testCanGetSetValue()
    {
        $this->collection->setValue('temperature_unit', 'F');

        $this->assertEquals('F', $this->collection->getValue('temperature_unit'));
    }

    public function testCanGetDefaultValue()
    {
        $this->assertEquals('C', $this->collection->getValue('temperature_unit'));
    }

    public function testWillGetNullIfNotSetAndNoDefaultValue()
    {
        $this->assertNull($this->collection->getValue('distance_unit'));
    }

    public function testGettingUndefinedSettingShouldThrowException()
    {
        $name = 'unknown';

        $this->expectExceptionMessage(
            sprintf("Collection '%s' doesn't have '%s' setting.", $this->collection->getOptions()->getName(), $name)
        );
        $this->expectException(SettingDoesNotExistException::class);
        $this->collection->getValue($name);
    }

    public function testSettingUndefinedSettingShouldThrowException()
    {
        $name = 'unknown';

        $this->expectException(SettingDoesNotExistException::class);
        $this->expectExceptionMessage(
            sprintf("Collection '%s' doesn't have '%s' setting.", $this->collection->getOptions()->getName(), $name)
        );
        $this->collection->setValue($name, 'value');
    }

    public function testCanGetSettingsListEvenIfTheyDoesNotExistInStorage()
    {
        $settings = $this->collection->getList();

        $this->assertCount(
            count($this->collection->getOptions()->getSettings()),
            $settings,
            'Collection should return all configured settings.'
        );
    }

    public function testCanGetSettingsListFromStorageAndMergeDefaultValues()
    {
        $this->collection->setValue('distance_unit', 'm');
        $settings = $this->collection->getList();

        $this->assertEquals('m', $settings['distance_unit']);
        $this->assertCount(
            count($this->collection->getOptions()->getSettings()),
            $settings,
            'Collection should return all configured settings.'
        );
    }

    public function testIsValidCanRecognizeValidAndInvalidValues()
    {
        $this->assertTrue($this->collection->isValid('distance_unit', 'm'));
        $this->assertFalse($this->collection->isValid('distance_unit', 'invalid'));
    }

    public function testShouldThrowExceptionIfSettingTypeIsNotConfigured()
    {
        $this->collection->getOptions()->setSettings([
            'setting_without_type' => [],
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Missing "type" option in setting configuration');
        $this->collection->isValid('setting_without_type', 'value');
    }

    public function testShouldThrowExceptionIfSettingTypeDoesNotExist()
    {
        $this->collection->getOptions()->setSettings([
            'setting_with_non_existing_type' => [
                'type' => 'not_exist',
            ],
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("SettingType 'not_exist' does not exist");
        $this->collection->isValid('setting_with_non_existing_type', 'value');
    }

    public function testShouldThrowExceptionIfSettingConfigInvalid()
    {
        $this->collection->getOptions()->setSettings([
            'invalid_setting_config' => '',
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            sprintf(
                "Failed to read 'invalid_setting_config' setting configuration in '%s' collection.",
                $this->collection->getOptions()->getName()
            )
        );
        $this->collection->isValid('invalid_setting_config', 'value');
    }
}
