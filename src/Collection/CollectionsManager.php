<?php

namespace Svycka\Settings\Collection;

use Svycka\Settings\Collection\Factory\SettingsCollectionAbstractFactory;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;

/**
 * Class CollectionsManager
 *
 * CollectionsManager implementation for managing settings collection
 *
 * @method CollectionInterface get($name)
 *
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class CollectionsManager extends AbstractPluginManager
{
    /**
     * An object type that the created instance must be instanced of
     *
     * @var null|string
     */
    protected $instanceOf = CollectionInterface::class;

    /**
     * {@inheritdoc}
     */
    public function __construct($configInstanceOrParentLocator = null, array $config = [])
    {
        parent::__construct($configInstanceOrParentLocator, $config);

        $this->addAbstractFactory(SettingsCollectionAbstractFactory::class);
    }

    /**
     * Validate the plugin
     *
     * Checks that the collection loaded is instance of CollectionInterface.
     *
     * @param  CollectionInterface $instance
     *
     * @return void
     * @throws InvalidServiceException if invalid
     *
     * @deprecated will be removed after zf2 support drop (only required to prevent deprecated warning)
     */
    public function validate($instance)
    {
        if (empty($this->instanceOf) || $instance instanceof $this->instanceOf) {
            return;
        }

        throw new InvalidServiceException(sprintf(
            'Plugin manager "%s" expected an instance of type "%s", but "%s" was received',
            __CLASS__,
            $this->instanceOf,
            is_object($instance) ? get_class($instance) : gettype($instance)
        ));
    }

    /**
     * Validate the plugin
     *
     * Checks that the collection loaded is instance of CollectionInterface.
     *
     * @param  CollectionInterface $instance
     *
     * @return void
     * @throws InvalidServiceException if invalid
     *
     * @deprecated will be removed after zf2 support drop
     */
    public function validatePlugin($instance)
    {
        $this->validate($instance);
    }
}
