<?php

namespace Svycka\Settings\Type\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Type\TypesManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);
        $serviceConfig = $options->getTypes();

        return new TypesManager($container, $serviceConfig);
    }
}
