<?php

namespace Svycka\Settings\Type;

use Laminas\I18n\Validator\IsInt;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class IntegerType extends AbstractSettingType
{
    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        $validator = new IsInt($this->options);
        return $validator->isValid($value);
    }
}
