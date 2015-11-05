<?php

namespace Svycka\Settings\Collection;

use Svycka\Settings\Entity\SettingInterface;
use Svycka\Settings\Exception\RuntimeException;
use Svycka\Settings\Exception\SettingDoesNotExistException;
use Svycka\Settings\Options\CollectionOptionsInterface;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Type\TypesManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsCollection implements CollectionInterface
{
    /**
     * @var StorageAdapterInterface
     */
    protected $adapter;

    /**
     * @var OwnerProviderInterface
     */
    protected $ownerProvider;

    /**
     * @var CollectionOptionsInterface
     */
    protected $options;

    /**
     * @var TypesManager
     */
    protected $typesManager;

    /**
     * @param CollectionOptionsInterface $options
     * @param StorageAdapterInterface    $adapter
     * @param OwnerProviderInterface     $owner_provider
     * @param TypesManager               $typesManager
     */
    public function __construct(
        CollectionOptionsInterface $options,
        StorageAdapterInterface $adapter,
        OwnerProviderInterface $owner_provider,
        TypesManager $typesManager
    ) {
        $this->adapter       = $adapter;
        $this->ownerProvider = $owner_provider;
        $this->options       = $options;
        $this->typesManager  = $typesManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($name, $value)
    {
        $settings = $this->options->getSettings();

        if (!array_key_exists($name, $settings)) {
            throw new SettingDoesNotExistException(sprintf(
                "Collection '%s' doesn't have '%s' setting.",
                $this->options->getName(),
                $name
            ));
        }

        $this->adapter->set($this, $this->ownerProvider->getIdentifier(), $name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($name)
    {
        $settingOptions = $this->getSettingOptions($name);

        $setting = $this->adapter->get($this, $this->ownerProvider->getIdentifier(), $name);

        if ($setting instanceof SettingInterface) {
            return $setting->getValue();
        }

        if (array_key_exists('default_value', $settingOptions)) {
            return $settingOptions['default_value'];
        }

        // if setting is configured without default value return null
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getList()
    {
        $settings = [];
        $storedSettings = $this->adapter->getList($this, $this->ownerProvider->getIdentifier());

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

    /**
     * {@inheritdoc}
     */
    public function isValid($name, $value)
    {
        $setting = $this->getSettingOptions($name);

        if (!isset($setting['type'])) {
            throw new RuntimeException('SettingType is not defined.');
        }

        if (!$this->typesManager->has($setting['type'])) {
            throw new RuntimeException(sprintf(
                "SettingType '%s' does not exist",
                is_string($setting['type']) ? $setting['type'] : gettype($setting['type'])
            ));
        }

        $type = $this->typesManager->get($setting['type']);

        if (!empty($setting['options']) && is_array($setting)) {
            $type->setOptions($setting['options']);
        }

        return $type->isValid($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $name
     *
     * @return array
     */
    private function getSettingOptions($name)
    {
        $settings = $this->options->getSettings();

        if (!array_key_exists($name, $settings)) {
            throw new SettingDoesNotExistException(sprintf(
                "Collection '%s' doesn't have '%s' setting.",
                $this->options->getName(),
                $name
            ));
        }

        if (!is_array($settings[$name])) {
            throw new RuntimeException(sprintf(
                "Failed to read '%s' setting configuration in '%s' collection.",
                $name,
                $this->options->getName()
            ));
        }

        return $settings[$name];
    }
}