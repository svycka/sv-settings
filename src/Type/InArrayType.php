<?php

namespace Svycka\Settings\Type;

use Zend\Validator\InArray;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class InArrayType extends AbstractSettingType
{
    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $validator = new InArray($this->options);
        return $validator->isValid($value);
    }
}