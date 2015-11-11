<?php

namespace TestAssets;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\MemoryStorage;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Type\TypesManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CustomCollection implements CollectionInterface
{
    /** @var StorageAdapterInterface */
    private $storage;
    private $ownerProvider;
    private $options;
    private $typesManager;

    public function __construct()
    {
        $this->storage = new MemoryStorage();
        $this->ownerProvider = new NullProvider();
        $this->options = new UserCollectionOptions();
        $this->typesManager = new TypesManager();
    }

    public function setValue($name, $value)
    {
        $this->storage->set($this, $this->ownerProvider->getIdentifier(), $name, $value);
    }

    public function getValue($name)
    {
        $setting = $this->storage->get($this, $this->ownerProvider->getIdentifier(), $name);
        if ($setting) {
            return $setting->getValue();
        }
        $options = $this->getOptions()->getSettings()[$name];
        if (isset($options['default_value'])) {
            return $options['default_value'];
        }

        return null;
    }

    public function isValid($name, $value)
    {
        $setting = $this->options->getSettings()[$name];
        $type = $this->typesManager->get($setting['type']);

        if (!empty($setting['options']) && is_array($setting)) {
            $type->setOptions($setting['options']);
        }

        return $type->isValid($value);
    }

    public function getList()
    {
        $settings = [];
        $storedSettings = $this->storage->getList($this, $this->ownerProvider->getIdentifier());

        /** @var SettingInterface $setting */
        foreach ($storedSettings as $setting) {
            $settings[$setting->getName()] = $setting->getValue();
        }

        $notSet = array_diff_key($this->options->getSettings(), $settings);

        foreach ($notSet as $name => $setting) {
            if (isset($setting['default_value'])) {
                $settings[$name] = $setting['default_value'];
            } else {
                $settings[$name] = null;
            }
        }

        return $settings;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setStorage(StorageAdapterInterface $storage)
    {
        $this->storage = $storage;
    }

    public function setOwnerProvider(OwnerProviderInterface $provider)
    {
        $this->ownerProvider = $provider;
    }
}
