<?php

namespace Svycka\Settings\Collection\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Options\CollectionOptions;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Type\TypesManager;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsCollectionAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param CollectionsManager|ServiceLocatorInterface $serviceLocator
     * @param string                                     $name
     * @param string                                     $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator);
        if (empty($config)) {
            return false;
        }

        return isset($config[$requestedName]);
    }

    /**
     * @param CollectionsManager|ServiceLocatorInterface $serviceLocator
     * @param string                                     $name
     * @param string                                     $requestedName
     *
     * @return SettingsCollection
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var CollectionsManager $serviceLocator */
        $serviceManager = $serviceLocator->getServiceLocator();

        $config = new CollectionOptions($this->config[$requestedName]);
        $config->setName($requestedName);
        /** @var StorageAdapterInterface $storage */
        $storage = $serviceManager->get($config->getStorageAdapter());
        /** @var OwnerProviderInterface $owner_provider */
        $owner_provider = $serviceManager->get($config->getOwnerProvider());
        /** @var TypesManager $typesManager */
        $typesManager = $serviceManager->get(TypesManager::class);

        return new SettingsCollection($config, $storage, $owner_provider, $typesManager);
    }


    /**
     * Retrieve configuration for settings collection, if any
     *
     * @param  CollectionsManager $collectionsManager
     *
     * @return array
     */
    protected function getConfig(CollectionsManager $collectionsManager)
    {
        if ($this->config !== null) {
            return $this->config;
        }

        /** @var ModuleOptions $options */
        $options = $collectionsManager->getServiceLocator()->get(ModuleOptions::class);
        $config  = $options->getCollections();

        $this->config = $config;
        return $this->config;
    }
}