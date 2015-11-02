<?php

namespace Svycka\Settings\Options;

use Svycka\Settings\Entity\Setting;
use Svycka\Settings\Provider\NullProvider;
use Zend\Stdlib\AbstractOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionOptions extends AbstractOptions implements CollectionOptionsInterface
{
    protected $objectClass   = Setting::class;
    protected $ownerProvider = NullProvider::class;
    protected $name;
    protected $storageAdapter;
    protected $settings;

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
