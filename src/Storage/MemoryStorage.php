<?php

namespace Svycka\Settings\Storage;

use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Entity\SettingInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class MemoryStorage implements StorageAdapterInterface
{
    protected $storage = [];

    /**
     * {@inheritdoc}
     */
    public function get(CollectionInterface $collection, $identifier, $name)
    {
        $options = $collection->getOptions();
        if (isset($this->storage[$options->getName()][$identifier][$name])) {
            $objectClass = $options->getObjectClass();
            /** @var SettingInterface $setting */
            $setting = new $objectClass;
            $setting->setCollection($options->getName());
            $setting->setIdentifier($identifier);
            $setting->setName($name);
            $setting->setValue($this->storage[$options->getName()][$identifier][$name]);
            return $setting;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function set(CollectionInterface $collection, $identifier, $name, $value)
    {
        $options = $collection->getOptions();
        $this->storage[$options->getName()][$identifier][$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(CollectionInterface $collection, $identifier)
    {
        $options = $collection->getOptions();
        $objectClass = $options->getObjectClass();
        $storedSettings = [];

        if (isset($this->storage[$options->getName()])) {
            $storedSettings = $this->storage[$options->getName()];
        }

        $settings = [];

        foreach ($storedSettings as $owner => $item) {
            if ($owner != $identifier) {
                continue;
            }

            foreach ($item as $name => $value) {
                /** @var SettingInterface $setting */
                $setting = new $objectClass;
                $setting->setCollection($options->getName());
                $setting->setIdentifier($identifier);
                $setting->setName($name);
                $setting->setValue($value);
                $settings[] = $setting;
            }
        }

        return $settings;
    }
}