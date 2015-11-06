<?php

namespace TestAssets;

use Svycka\Settings\Collection\CollectionInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CustomCollection implements CollectionInterface
{
    public function setValue($name, $value)
    {
    }

    public function getValue($name)
    {
    }

    public function isValid($name, $value)
    {
    }

    public function getList()
    {
    }

    public function getOptions()
    {
    }
}
