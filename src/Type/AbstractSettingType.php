<?php

namespace Svycka\Settings\Type;

use Svycka\Settings\Exception\InvalidArgumentException;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
abstract class AbstractSettingType implements SettingTypeInterface
{
    protected $options = [];

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException(__METHOD__.' expects an array.');
        }

        $this->options = $options;
    }
}