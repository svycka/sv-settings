<?php

namespace Svycka\Settings\Controller\Factory;

use Svycka\Settings\Collection\CollectionsManager;
use Svycka\Settings\Controller\SettingsApiController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsApiControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SettingsApiController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\Mvc\Controller\ControllerManager $serviceLocator */
        $serviceManager = $serviceLocator->getServiceLocator();
        /** @var CollectionsManager $manager */
        $manager = $serviceManager->get(CollectionsManager::class);

        return new SettingsApiController($manager);
    }
}