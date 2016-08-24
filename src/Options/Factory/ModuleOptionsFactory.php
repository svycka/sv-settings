<?php

namespace Svycka\Settings\Options\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Options\ModuleOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ModuleOptionsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ModuleOptions($container->get('config')['sv-settings']);
    }
}
