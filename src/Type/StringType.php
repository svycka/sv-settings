<?php

namespace Svycka\Settings\Type;

use Zend\Validator\StringLength;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class StringType extends AbstractSettingType
{
    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $validator = new StringLength($this->options);
        return $validator->isValid($value);
    }
}
