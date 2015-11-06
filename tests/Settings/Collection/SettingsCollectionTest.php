<?php

namespace Svycka\SettingsTest\Collection;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use Svycka\Settings\Options\CollectionOptionsInterface;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Type\TypesManager;
use TestAssets\UserCollectionOptions;

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
            new TypesManager()
        );
    }

    public function testConstructorCanCreateCollectionWithInterfaces()
    {
        /** @var CollectionOptionsInterface $options */
        $options = $this->getMock(CollectionOptionsInterface::class);
        /** @var StorageAdapterInterface $adapter */
        $adapter = $this->getMock(StorageAdapterInterface::class);
        /** @var OwnerProviderInterface $owner_provider */
        $owner_provider = $this->getMock(OwnerProviderInterface::class);
        /** @var TypesManager $types_manager */
        $types_manager = $this->getMock(TypesManager::class);

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

        $this->setExpectedException(
            SettingDoesNotExistException::class,
            sprintf("Collection '%s' doesn't have '%s' setting.", $this->collection->getOptions()->getName(), $name)
        );
        $this->collection->getValue($name);
    }

    public function testSettingUndefinedSettingShouldThrowException()
    {
        $name = 'unknown';

        $this->setExpectedException(
            SettingDoesNotExistException::class,
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
}