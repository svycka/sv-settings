<?php

namespace Svycka\Settings\Type;

use Zend\Validator\Regex;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class RegexType extends AbstractSettingType
{
    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $validator = new Regex($this->options);
        return $validator->isValid($value);
    }
}
