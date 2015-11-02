<?php

namespace Svycka\Settings\Collection\Factory;

use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Collection\CollectionsManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ModuleOptions $options */
        $options = $serviceLocator->get(ModuleOptions::class);
        $serviceConfig = new Config($options->getSettingsManager());

        return new CollectionsManager($serviceConfig);
    }
}