<?php

namespace Svycka\Settings\Service;

use Svycka\Settings\Collection\CollectionsManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingsService
{
    /**
     * @var CollectionsManager
     */
    protected $collections;

    public function __construct(CollectionsManager $collections)
    {
        $this->collections = $collections;
    }

    /**
     * @param $name
     *
     * @return \Svycka\Settings\Collection\CollectionInterface
     */
    public function getCollection($name)
    {
        return $this->collections->get($name);
    }

    public function getValue($key, $collection_name)
    {
        return $this->getCollection($collection_name)->getValue($key);
    }

    public function setValue($key, $value, $collection_name)
    {
        return $this->getCollection($collection_name)->setValue($key, $value);
    }
}