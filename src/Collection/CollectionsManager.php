<?php

namespace Svycka\Settings\Collection;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Collection\Factory\SettingsCollectionAbstractFactory;
use Laminas\ServiceManager\AbstractPluginManager;

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
final class CollectionsManager extends AbstractPluginManager
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
    public function __construct(ContainerInterface $container = null, array $config = [])
    {
        parent::__construct($container, $config);

        $this->addAbstractFactory(SettingsCollectionAbstractFactory::class);
    }
}
