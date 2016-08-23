<?php

namespace Svycka\Settings\Type;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\RuntimeException;

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
class TypesManager extends AbstractPluginManager
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
     * @workaround: for https://github.com/zendframework/zend-servicemanager/issues/50
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
    public function validatePlugin($type)
    {
        if ($type instanceof SettingTypeInterface) {
            return; // we're okay
        }
        throw new RuntimeException(sprintf(
            'SettingType of type "%s" is invalid; must implement "%s"',
            (is_object($type) ? get_class($type) : gettype($type)),
            SettingTypeInterface::class
        ));
    }

    /**
     * Override setInvokableClass().
     *
     * Performs normal operation, but also auto-aliases the class name to the
     * service name. This ensures that providing the FQCN does not trigger an
     * abstract factory later.
     *
     * @param  string       $name
     * @param  string       $invokableClass
     * @param  null|bool    $shared
     * @return TypesManager
     */
    public function setInvokableClass($name, $invokableClass, $shared = null)
    {
        parent::setInvokableClass($name, $invokableClass, $shared);
        if ($name != $invokableClass) {
            $this->setAlias($invokableClass, $name);
        }

        return $this;
    }
}
