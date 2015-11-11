<?php

namespace Svycka\Settings\Storage\Factory;

use Svycka\Settings\Storage\DoctrineStorage;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class DoctrineStorageFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DoctrineStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // todo: maybe add config options for storage? Would not force orm_default.

        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        return new DoctrineStorage($entityManager);
    }
}
