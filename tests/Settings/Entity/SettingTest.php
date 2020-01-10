<?php

namespace Svycka\SettingsTest\Entity;

use Svycka\Settings\Entity\Setting;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class SettingTest extends \PHPUnit\Framework\TestCase
{
    /** @var Setting */
    private $setting;

    public function setUp()
    {
        $this->setting = new Setting();
    }

    public function testCanSetGetId()
    {
        $this->setting->setId($value = 1);
        $this->assertSame($value, $this->setting->getId());
    }

    public function testCanSetGetName()
    {
        $this->setting->setName($value = 'name');
        $this->assertSame($value, $this->setting->getName());
    }

    public function testCanSetGetCollection()
    {
        $this->setting->setCollection($value = 'collection');
        $this->assertSame($value, $this->setting->getCollection());
    }

    public function testCanSetGetValue()
    {
        $this->setting->setValue($value = 'value');
        $this->assertSame($value, $this->setting->getValue());
    }

    public function testCanSetGetIdentifier()
    {
        $this->setting->setIdentifier($value = 'identifier');
        $this->assertSame($value, $this->setting->getIdentifier());
    }
}
