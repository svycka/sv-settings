<?php

namespace Svycka\Settings;

return [
    'controllers' => [
        'factories' => [
            Controller\SettingsApiController::class => Controller\Factory\SettingsApiControllerFactory::class,
        ]
    ],

    'service_manager' => [
        'factories' => [
            Options\ModuleOptions::class => Options\Factory\ModuleOptionsFactory::class,
            Service\SettingsService::class => Service\Factory\SettingsServiceFactory::class,
            Collection\CollectionsManager::class => Collection\Factory\CollectionsManagerFactory::class,
            Type\TypesManager::class => Type\Factory\TypesManagerFactory::class,
            Storage\DoctrineStorage::class => Storage\Factory\DoctrineStorageFactory::class,
            Provider\ZfcUserProvider::class => Provider\Factory\ZfcUserProviderFactory::class,
        ],
        'invokables' => [
            Provider\NullProvider::class => Provider\NullProvider::class,
        ]
    ],

    'sv-settings' => [
        'settings_manager' => [
            'abstract_factories' => [
                Collection\Factory\SettingsCollectionAbstractFactory::class,
            ],
        ],
        'types' => [
            // todo: array, string, bool, int, custom..
        ],
    ],
];
