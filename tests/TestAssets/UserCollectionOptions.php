<?php

namespace TestAssets;

use Svycka\Settings\Entity\Setting;
use Svycka\Settings\Options\CollectionOptions;
use Svycka\Settings\Provider\NullProvider;
use Svycka\Settings\Storage\MemoryStorage;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class UserCollectionOptions extends CollectionOptions
{
    protected $objectClass   = Setting::class;
    protected $ownerProvider = NullProvider::class;
    protected $name = 'user-settings';
    protected $storageAdapter = MemoryStorage::class;
    protected $settings = [
        'temperature_unit' => [
            'default_value' => 'C',
            'type'          => 'in_array',
            'options'       => [
                'haystack' => ['C', 'F'],
                'strict'   => \Zend\Validator\InArray::COMPARE_STRICT,
            ]
        ],
        'distance_unit'    => [
            // removed optional default value
            //'default_value' => 'km',
            'type'          => 'in_array',
            'options'       => [
                'haystack' => [
                    'km', 'm', 'mi', 'yd',
                ],
                'strict'   => \Zend\Validator\InArray::COMPARE_STRICT,
            ]
        ],
        'locale'           => [
            'default_value' => 'en-US',
            'type'          => 'regex',
            'options'       => [
                'pattern' => '/^[a-z]{2,3}(-|-[A-Z]{2,3})?$/',
            ]
        ],
    ];
}
