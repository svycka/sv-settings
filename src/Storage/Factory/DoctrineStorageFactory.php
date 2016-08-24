<?php

namespace Svycka\Settings\Storage\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Storage\DoctrineStorage;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class DoctrineStorageFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     *
     * @return DoctrineStorage
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new DoctrineStorage($entityManager);
    }
}
