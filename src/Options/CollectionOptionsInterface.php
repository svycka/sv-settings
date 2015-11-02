<?php

namespace Svycka\Settings\Options;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
interface CollectionOptionsInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getStorageAdapter();

    /**
     * @param string $adapter
     */
    public function setStorageAdapter($adapter);

    /**
     * @return string
     */
    public function getOwnerProvider();

    /**
     * @param string $provider
     */
    public function setOwnerProvider($provider);

    /**
     * @return array
     */
    public function getSettings();

    /**
     * @param array $settings
     */
    public function setSettings($settings);

    /**
     * @return string
     */
    public function getObjectClass();

    /**
     * @param string $class
     */
    public function setObjectClass($class);
}