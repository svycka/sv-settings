<?php

namespace Svycka\SettingsTest\Storage\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Svycka\Settings\Storage\DoctrineStorage;
use Svycka\Settings\Storage\Factory\DoctrineStorageFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class DoctrineStorageFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get('doctrine.entitymanager.orm_default')
            ->willReturn($this->prophesize(EntityManagerInterface::class)->reveal());

        $factory = new DoctrineStorageFactory();
        $storage = $factory($serviceManager->reveal());
        $this->assertInstanceOf(DoctrineStorage::class, $storage);
    }
}
