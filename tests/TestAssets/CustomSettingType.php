<?php

namespace TestAssets;

use Svycka\Settings\Type\SettingTypeInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CustomSettingType implements SettingTypeInterface
{
    /**
     * @param array $options
     */
    public function setOptions($options)
    {
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        return (bool)$value;
    }
}
