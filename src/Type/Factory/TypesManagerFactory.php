<?php

namespace Svycka\Settings\Type\Factory;

use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Type\TypesManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ModuleOptions $options */
        $options = $serviceLocator->get(ModuleOptions::class);
        $serviceConfig = new Config($options->getTypes());

        return new TypesManager($serviceConfig);
    }
}
