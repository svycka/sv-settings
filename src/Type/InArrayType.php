<?php

namespace Svycka\Settings\Type;

use Laminas\Validator\InArray;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class InArrayType extends AbstractSettingType
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
