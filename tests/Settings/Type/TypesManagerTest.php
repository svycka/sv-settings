<?php

namespace Svycka\SettingsTest\Type;

use Svycka\Settings\Type\FloatType;
use Svycka\Settings\Type\InArrayType;
use Svycka\Settings\Type\IntegerType;
use Svycka\Settings\Type\RegexType;
use Svycka\Settings\Type\StringType;
use Svycka\Settings\Type\TypesManager;
use TestAssets\CustomSettingType;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class TypesManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testHasDefaultTypes()
    {
        $manager = new TypesManager(new ServiceManager());
        $types = [
            'inarray',
            InArrayType::class,
            'integer',
            IntegerType::class,
            'regex',
            RegexType::class,
            'float',
            FloatType::class,
            'string',
            StringType::class,
        ];
        foreach ($types as $type) {
            $this->assertTrue($manager->has($type), sprintf('"%s" type should exist', $type));
        }
    }

    public function testCanGetDefaultTypes()
    {
        $manager = new TypesManager(new ServiceManager());
        $this->assertInstanceOf(InArrayType::class, $manager->get(InArrayType::class));
        $this->assertInstanceOf(IntegerType::class, $manager->get(IntegerType::class));
        $this->assertInstanceOf(RegexType::class, $manager->get(RegexType::class));
        $this->assertInstanceOf(FloatType::class, $manager->get(FloatType::class));
        $this->assertInstanceOf(StringType::class, $manager->get(StringType::class));
    }

    public function testCanAddCustomType()
    {
        $config = [
            'factories' => [
                CustomSettingType::class => InvokableFactory::class,
            ],
            'aliases' => [
                'custom_type' => CustomSettingType::class,
            ],
        ];
        $manager = new TypesManager(new ServiceManager(), $config);

        $this->assertTrue($manager->has('custom_type'));
        $this->assertTrue($manager->has(CustomSettingType::class));
        $this->assertInstanceOf(CustomSettingType::class, $manager->get('custom_type'));
    }

    public function testDoesNotAllowInvalidTypes()
    {
        $config = [
            'factories' => [
                \stdClass::class => InvokableFactory::class,
            ],
            'aliases' => [
                'invalid_type' => \stdClass::class,
            ]
        ];
        $manager = new TypesManager(new ServiceManager(), $config);

        $this->expectException(InvalidServiceException::class);
        $manager->get('invalid_type');
    }
}
