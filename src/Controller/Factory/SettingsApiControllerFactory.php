<?php

namespace Svycka\Settings\Controller\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Controller\SettingsApiController;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class SettingsApiControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var CollectionsManager $manager */
        $manager = $container->get(CollectionsManager::class);

        return new SettingsApiController($manager);
    }
}
