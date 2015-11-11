<?php

namespace Svycka\Settings\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    protected $types = [];
    protected $settingsManager = [];
    protected $collections = [];

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param array $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }

    /**
     * @return array
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @param array $collections
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;
    }

    /**
     * @return array
     */
    public function getSettingsManager()
    {
        return $this->settingsManager;
    }

    /**
     * @param array $settingsManager
     */
    public function setSettingsManager($settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }
}
