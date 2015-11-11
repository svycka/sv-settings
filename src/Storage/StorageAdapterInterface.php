<?php

namespace Svycka\Settings\Storage;

use Svycka\Settings\Collection\CollectionInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface StorageAdapterInterface
{
    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     * @param string              $name
     *
     * @return null|\Svycka\Settings\Entity\SettingInterface
     */
    public function get(CollectionInterface $collection, $identifier, $name);

    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     * @param string              $name
     * @param string              $value
     */
    public function set(CollectionInterface $collection, $identifier, $name, $value);

    /**
     * @param CollectionInterface $collection
     * @param mixed               $identifier
     *
     * @return array
     */
    public function getList(CollectionInterface $collection, $identifier);
}
