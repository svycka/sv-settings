<?php

namespace Svycka\Settings\Collection;

use Zend\ServiceManager\AbstractPluginManager;

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
     * Validate the plugin
     *
     * Checks that the collection loaded is instance of CollectionInterface.
     *
     * @param  CollectionInterface $collection
     *
     * @return void
     * @throws \RuntimeException if invalid
     */
    public function validatePlugin($collection)
    {
        if ($collection instanceof CollectionInterface) {
            return; // we're okay
        }
        throw new \RuntimeException(sprintf(
            'Settings collection of type %s is invalid; must implement %s',
            (is_object($collection) ? get_class($collection) : gettype($collection)),
            CollectionInterface::class
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
     * @return CollectionsManager
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