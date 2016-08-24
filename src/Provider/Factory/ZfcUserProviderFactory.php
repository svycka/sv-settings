<?php

namespace Svycka\Settings\Provider\Factory;

use Interop\Container\ContainerInterface;
use Svycka\Settings\Provider\ZfcUserProvider;
use Zend\Authentication\AuthenticationService;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ZfcUserProviderFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     *
     * @return ZfcUserProvider
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $container->get('zfcuser_auth_service');

        return new ZfcUserProvider($authenticationService);
    }
}
