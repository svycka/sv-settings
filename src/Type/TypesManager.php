<?php

namespace Svycka\Settings\Type;

use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Exception\InvalidServiceException;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class TypesManager
 *
 * TypesManager implementation for managing settings type
 *
 * @method SettingTypeInterface get($name)
 *
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class TypesManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $factories = [
        InArrayType::class => InvokableFactory::class,
        RegexType::class => InvokableFactory::class,
        IntegerType::class => InvokableFactory::class,
        FloatType::class => InvokableFactory::class,
        StringType::class => InvokableFactory::class,
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'inarray' => InArrayType::class,
        'regex'   => RegexType::class,
        'integer' => IntegerType::class,
        'float' => FloatType::class,
        'string' => StringType::class,
    ];

    /**
     * Whether or not to share by default; default to false
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * Validate the plugin
     *
     * Checks that the type loaded is instance of SettingTypeInterface.
     *
     * @param  SettingTypeInterface $type
     *
     * @return void
     * @throws \RuntimeException if invalid
     */
    public function validate($type)
    {
        if ($type instanceof SettingTypeInterface) {
            return; // we're okay
        }
        throw new InvalidServiceException(sprintf(
            'SettingType of type "%s" is invalid; must implement "%s"',
            (is_object($type) ? get_class($type) : gettype($type)),
            SettingTypeInterface::class
        ));
    }
}
