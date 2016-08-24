<?php

namespace Svycka\Settings\Collection\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Collection\SettingsCollection;
use Svycka\Settings\Options\CollectionOptions;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Provider\OwnerProviderInterface;
use Svycka\Settings\Storage\StorageAdapterInterface;
use Svycka\Settings\Type\TypesManager;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsCollectionAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        /** @var CollectionsManager $config */
        $config = $container->get(ModuleOptions::class)->getCollections();
        if (empty($config)) {
            return false;
        }

        return isset($config[$requestedName]);
    }

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $collectionsConfig = $container->get(ModuleOptions::class)->getCollections();
        $config = new CollectionOptions($collectionsConfig[$requestedName]);
        $config->setName($requestedName);

        /** @var StorageAdapterInterface $storage */
        $storage = $container->get($config->getStorageAdapter());
        /** @var OwnerProviderInterface $owner_provider */
        $owner_provider = $container->get($config->getOwnerProvider());
        /** @var TypesManager $typesManager */
        $typesManager = $container->get(TypesManager::class);

        return new SettingsCollection($config, $storage, $owner_provider, $typesManager);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated will be removed after zf2 support drop
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->canCreate($serviceLocator->getServiceLocator(), $requestedName);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated will be removed after zf2 support drop
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this($serviceLocator->getServiceLocator(), $requestedName);
    }
}
