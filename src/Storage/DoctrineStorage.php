<?php

namespace Svycka\Settings\Storage;

use Doctrine\ORM\EntityManagerInterface;
use Svycka\Settings\Collection\CollectionInterface;
use Svycka\Settings\Entity\SettingInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class DoctrineStorage implements StorageAdapterInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     * @param string              $name
     *
     * @return null|SettingInterface
     */
    public function get(CollectionInterface $collection, $identifier, $name)
    {
        $options    = $collection->getOptions();
        $repository = $this->entityManager->getRepository($options->getObjectClass());

        return $repository->findOneBy([
            'collection' => $options->getName(),
            'name'       => $name,
            'identifier' => $identifier
        ]);
    }

    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     * @param string              $name
     * @param string              $value
     */
    public function set(CollectionInterface $collection, $identifier, $name, $value)
    {
        $options = $collection->getOptions();
        $setting = $this->get($collection, $identifier, $name);

        if (!$setting) {
            $objectClassName = $options->getObjectClass();
            /** @var SettingInterface $setting */
            $setting = new $objectClassName;
            $setting->setName($name);
            $setting->setIdentifier($identifier);
            $setting->setCollection($options->getName());
        }

        $setting->setValue($value);

        $this->entityManager->persist($setting);
        $this->entityManager->flush($setting);
    }

    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     *
     * @return array
     */
    public function getList(CollectionInterface $collection, $identifier)
    {
        $options    = $collection->getOptions();
        $repository = $this->entityManager->getRepository($options->getObjectClass());

        return $repository->findBy([
            'collection' => $options->getName(),
            'identifier' => $identifier
        ]);
    }
}
