<?php

namespace Svycka\Settings;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
final class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }
}
