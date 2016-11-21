<?php

namespace Svycka\Settings\Service\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Service\SettingsService;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class SettingsServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var CollectionsManager $collectionsManager */
        $collectionsManager = $container->get(CollectionsManager::class);

        return new SettingsService($collectionsManager);
    }
}
