<?php

namespace Svycka\Settings\Entity;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface SettingInterface
{
    public function setValue($value);
    public function getValue();
    public function setName($name);
    public function getName();
    public function setCollection($name);
    public function getCollection();
    public function setIdentifier($identifier);
    public function getIdentifier();
}
