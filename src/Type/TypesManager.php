<?php

namespace Svycka\Settings\Type;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\RuntimeException;

/**
 * Class TypesManager
 *
 * TypesManager implementation for managing settings type
 *
 * @method SettingTypeInterface get($name)
 *
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManager extends AbstractPluginManager
{
    /**
     * Whether or not to share by default; default to false
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * Validate the plugin
     *
     * Checks that the type loaded is instance of SettingTypeInterface.
     *
     * @param  SettingTypeInterface $type
     *
     * @return void
     * @throws \RuntimeException if invalid
     */
    public function validatePlugin($type)
    {
        if ($type instanceof SettingTypeInterface) {
            return; // we're okay
        }
        throw new RuntimeException(sprintf(
            'SettingType of type %s is invalid; must implement %s',
            (is_object($type) ? get_class($type) : gettype($type)),
            SettingTypeInterface::class
        ));
    }
}