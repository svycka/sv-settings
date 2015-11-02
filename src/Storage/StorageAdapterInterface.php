<?php

namespace Svycka\Settings\Storage;

use Svycka\Settings\Collection\CollectionInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface StorageAdapterInterface
{
    public function get(CollectionInterface $collection, $identifier, $name);
    public function set(CollectionInterface $collection, $identifier, $name, $value);
    public function getList(CollectionInterface $collection, $identifier);
}