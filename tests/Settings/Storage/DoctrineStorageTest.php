<?php

namespace Svycka\SettingsTest\Storage;

use Doctrine\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Prophecy\Argument\Token\CallbackToken;
use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Entity\Setting;
use Svycka\Settings\Entity\SettingInterface;
use Svycka\Settings\Storage\DoctrineStorage;
use TestAssets\CustomCollection;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class DoctrineStorageTest extends \PHPUnit\Framework\TestCase
{
    /** @var CollectionInterface */
    private $collection;

    public function setUp(): void
    {
        $this->collection = new CustomCollection();
    }

    public function testCanGetValue()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findOneBy([
            'collection' => $this->collection->getOptions()->getName(),
            'name'       => $name = 'temperature_unit',
            'identifier' => $identifier = 'user1'
        ])->willReturn($setting = new Setting())->shouldBeCalled();
        $entityManager = $this->prophesize(EntityManagerInterface::class);
        $entityManager->getRepository($this->collection->getOptions()->getObjectClass())
            ->willReturn($repository->reveal());

        $storage = new DoctrineStorage($entityManager->reveal());
        $this->assertSame($setting, $storage->get($this->collection, $identifier, $name));
    }

    public function testCanCreate()
    {
        $entity = new CallbackToken(
            function (SettingInterface $value) {
                $this->assertInstanceOf($this->collection->getOptions()->getObjectClass(), $value);
                $this->assertEquals('temperature_unit', $value->getName());
                $this->assertEquals('F', $value->getValue());
                $this->assertEquals('user1', $value->getIdentifier());
                $this->assertEquals($this->collection->getOptions()->getName(), $value->getCollection());
                return true;
            }
        );
        $entityManager = $this->prophesize(EntityManagerInterface::class);
        $entityManager->persist($entity)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findOneBy([
            'collection' => $this->collection->getOptions()->getName(),
            'name'       => 'temperature_unit',
            'identifier' => 'user1'
        ])->willReturn(null);
        $entityManager->getRepository(\Svycka\Settings\Entity\Setting::class)->willReturn($repository->reveal());

        $storage = new DoctrineStorage($entityManager->reveal());
        $storage->set($this->collection, 'user1', 'temperature_unit', 'F');
    }

    public function testCanUpdate()
    {
        $setting = $this->prophesize(SettingInterface::class);
        $setting->setValue($value = 'F')->shouldBeCalled();
        $entityManager = $this->prophesize(EntityManagerInterface::class);
        $entityManager->persist($setting->reveal())->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findOneBy([
            'collection' => $this->collection->getOptions()->getName(),
            'name'       => 'temperature_unit',
            'identifier' => 'user1'
        ])->willReturn($setting->reveal());
        $entityManager->getRepository(\Svycka\Settings\Entity\Setting::class)->willReturn($repository->reveal());

        $storage = new DoctrineStorage($entityManager->reveal());
        $storage->set($this->collection, 'user1', 'temperature_unit', $value);
    }

    public function testCanGetSettingsList()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findBy([
            'collection' => $this->collection->getOptions()->getName(),
            'identifier' => 'user1'
        ])->willReturn($list = [123])->shouldBeCalled();
        $entityManager = $this->prophesize(EntityManagerInterface::class);
        $entityManager->getRepository($this->collection->getOptions()->getObjectClass())
            ->willReturn($repository->reveal());

        $storage = new DoctrineStorage($entityManager->reveal());
        $this->assertSame($list, $storage->getList($this->collection, 'user1'));
    }
}
