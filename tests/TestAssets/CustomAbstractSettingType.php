<?php

namespace TestAssets;

use Svycka\Settings\Type\AbstractSettingType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CustomAbstractSettingType extends AbstractSettingType
{
    /**
     * @return array $options
     */
    public function getOptions()
    {
        return $this->options;
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
