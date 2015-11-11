<?php

namespace Svycka\Settings\Options;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface ModuleOptionsInterface
{
    /**
     * @return array
     */
    public function getTypes();

    /**
     * @param array $types
     */
    public function setTypes($types);

    /**
     * @return array
     */
    public function getCollections();

    /**
     * @param array $collections
     */
    public function setCollections($collections);

    /**
     * @return array
     */
    public function getSettingsManager();

    /**
     * @param array $settingsManager
     */
    public function setSettingsManager($settingsManager);
}
