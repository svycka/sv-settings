<?php

namespace Svycka\Settings\Collection;

use Svycka\Settings\Exception\RuntimeException;
use Svycka\Settings\Exception\SettingDoesNotExistException;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface CollectionInterface
{
    /**
     * Gets setting value from collection
     *
     * @param string $name
     * @param mixed $value
     *
     * @throws SettingDoesNotExistException
     */
    public function setValue($name, $value);

    /**
     * Sets settings value to collection
     *
     * @param string $name
     *
     * @return mixed
     * @throws SettingDoesNotExistException
     * @throws RuntimeException
     */
    public function getValue($name);

    /**
     * Validates value by setting name against setting configured type
     *
     * @param string $name
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($name, $value);

    /**
     * Returns all configured settings in this collection.
     * If not exists in storage will return default value or null.
     *
     * @return array
     */
    public function getList();

    /**
     * @return \Svycka\Settings\Options\CollectionOptionsInterface
     */
    public function getOptions();
}
