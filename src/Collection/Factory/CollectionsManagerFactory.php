<?php

namespace Svycka\Settings\Collection\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Options\ModuleOptions;
use Svycka\Settings\Collection\CollectionsManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class CollectionsManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var ModuleOptions $options */
        $options = $container->get(ModuleOptions::class);

        return new CollectionsManager($container, $options->getSettingsManager());
    }
}
