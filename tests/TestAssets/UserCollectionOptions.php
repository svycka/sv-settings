<?php

namespace TestAssets;

use Svycka\Settings\Entity\Setting;
use Svycka\Settings\Options\CollectionOptionsInterface;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Type\InArrayType;
use Laminas\Stdlib\AbstractOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class UserCollectionOptions extends AbstractOptions implements CollectionOptionsInterface
{
    protected $objectClass   = Setting::class;
    protected $ownerProvider = NullProvider::class;
    protected $name = 'user-settings';
    protected $storageAdapter = MemoryStorage::class;
    protected $settings = [
        'temperature_unit' => [
            'default_value' => 'C',
            'type'          => 'inarray',
            'options'       => [
                'haystack' => ['C', 'F'],
                'strict'   => \Laminas\Validator\InArray::COMPARE_STRICT,
            ]
        ],
        'distance_unit'    => [
            // removed optional default value
            //'default_value' => 'km',
            'type'          => InArrayType::class,
            'options'       => [
                'haystack' => [
                    'km', 'm', 'mi', 'yd',
                ],
                'strict'   => \Laminas\Validator\InArray::COMPARE_STRICT,
            ]
        ],
        'locale'           => [
            'default_value' => 'en-US',
            'type'          => 'regex',
            'options'       => [
                'pattern' => '/^[a-z]{2,3}(-|-[A-Z]{2,3})?$/',
            ]
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * {@inheritdoc}
     */
    public function setObjectClass($class)
    {
        $this->objectClass = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getStorageAdapter()
    {
        return $this->storageAdapter;
    }

    /**
     * {@inheritdoc}
     */
    public function setStorageAdapter($adapter)
    {
        $this->storageAdapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerProvider()
    {
        return $this->ownerProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwnerProvider($ownerProvider)
    {
        $this->ownerProvider = $ownerProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }
}
