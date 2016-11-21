<?php

namespace Svycka\Settings\Type;

use Zend\I18n\Validator\IsFloat;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class FloatType extends AbstractSettingType
{
    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $validator = new IsFloat($this->options);
        return $validator->isValid($value);
    }
}
