<?php

namespace Svycka\Settings\Service\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Service\SettingsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var CollectionsManager $collectionsManager */
        $collectionsManager = $serviceLocator->get(CollectionsManager::class);

        return new SettingsService($collectionsManager);
    }
}