<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Exception\InvalidArgumentException;
use Svycka\Settings\Type\AbstractSettingType;
use TestAssets\CustomAbstractSettingType;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class AbstractSettingTypeTest extends \PHPUnit\Framework\TestCase
{
    /** @var CustomAbstractSettingType */
    private $type;

    public function setUp()
    {
        $this->type = new CustomAbstractSettingType;
    }

    public function testCanSetOptionsThroughConstructor()
    {
        $type = new CustomAbstractSettingType($options = ['options']);
        $this->assertSame($options, $type->getOptions());
    }

    public function testCanSetGetOptions()
    {
        $this->type->setOptions($options = ['options']);
        $this->assertSame($options, $this->type->getOptions());
    }

    public function testWillThrowExceptionIfInvalidOptionsProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('%s::setOptions expects an array', AbstractSettingType::class));

        $this->type->setOptions(new \stdClass());
    }
}
