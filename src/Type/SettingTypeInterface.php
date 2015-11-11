<?php

namespace Svycka\Settings\Type;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface SettingTypeInterface
{
    /**
     * @param array $options
     */
    public function setOptions($options);

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value);
}
