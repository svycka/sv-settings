<?php

namespace Svycka\Settings\Service;

use Svycka\Settings\Collection\CollectionsManager;

/**
 * @author  Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsService
{
    /**
     * @var CollectionsManager
     */
    protected $collections;

    /**
     * SettingsService constructor.
     *
     * @param CollectionsManager $collections
     */
    public function __construct(CollectionsManager $collections)
    {
        $this->collections = $collections;
    }

    /**
     * @param string $name
     *
     * @return \Svycka\Settings\Collection\CollectionInterface
     */
    public function getCollection($name)
    {
        return $this->collections->get($name);
    }

    /**
     * @param string $collection_name
     * @param string $key
     *
     * @return mixed
     */
    public function getValue($collection_name, $key)
    {
        return $this->getCollection($collection_name)->getValue($key);
    }

    /**
     * @param string $collection_name
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setValue($collection_name, $key, $value)
    {
        return $this->getCollection($collection_name)->setValue($key, $value);
    }

    /**
     * @param string $collection_name
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function isValid($collection_name, $key, $value)
    {
        return $this->getCollection($collection_name)->isValid($key, $value);
    }
}
