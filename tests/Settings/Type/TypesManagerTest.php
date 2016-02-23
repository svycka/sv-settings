<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\FloatType;
use Svycka\Settings\Type\InArrayType;
use Svycka\Settings\Type\IntegerType;
use Svycka\Settings\Type\RegexType;
use Svycka\Settings\Type\StringType;
use Svycka\Settings\Type\TypesManager;
use TestAssets\CustomSettingType;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Exception\RuntimeException;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testHasDefaultTypes()
    {
        $manager = new TypesManager();
        $this->assertTrue($manager->has('in_array'));
        $this->assertTrue($manager->has(InArrayType::class));
        $this->assertTrue($manager->has('integer'));
        $this->assertTrue($manager->has(IntegerType::class));
        $this->assertTrue($manager->has('regex'));
        $this->assertTrue($manager->has(RegexType::class));
        $this->assertTrue($manager->has('float'));
        $this->assertTrue($manager->has(FloatType::class));
        $this->assertTrue($manager->has('string'));
        $this->assertTrue($manager->has(StringType::class));
    }

    public function testCanGetDefaultTypes()
    {
        $manager = new TypesManager();
        $this->assertInstanceOf(InArrayType::class, $manager->get(InArrayType::class));
        $this->assertInstanceOf(IntegerType::class, $manager->get(IntegerType::class));
        $this->assertInstanceOf(RegexType::class, $manager->get(RegexType::class));
        $this->assertInstanceOf(FloatType::class, $manager->get(FloatType::class));
        $this->assertInstanceOf(StringType::class, $manager->get(StringType::class));
    }

    public function testCanAddCustomType()
    {
        $config = new Config(['invokables' => [
            'custom_type' => CustomSettingType::class,
        ]]);
        $manager = new TypesManager($config);

        $this->assertTrue($manager->has('custom_type'));
        $this->assertTrue($manager->has(CustomSettingType::class));
        $this->assertInstanceOf(CustomSettingType::class, $manager->get('custom_type'));
    }

    public function testDoesNotAllowInvalidTypes()
    {
        $config = new Config([
            'invokables' => [
                'custom_type' => \stdClass::class,
            ]
        ]);
        $manager = new TypesManager($config);

        $this->setExpectedException(RuntimeException::class);
        $manager->get('custom_type');
    }
}
