<?php

namespace Svycka\SettingsTest\Provider;

use Svycka\Settings\Exception\RuntimeException;
use Svycka\Settings\Provider\ZfcUserProvider;
use Zend\Authentication\AuthenticationService;
use ZfcUser\Entity\UserInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ZfcUserProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetIdentifier()
    {
        $identity = $this->prophesize(UserInterface::class);
        $identity->getId()->willReturn($identifier = 123);
        $authenticationService = $this->prophesize(AuthenticationService::class);
        $authenticationService->getIdentity()->willReturn($identity);

        $provider = new ZfcUserProvider($authenticationService->reveal());
        $this->assertEquals($identifier, $provider->getIdentifier());
    }

    public function testThrowExceptionWhenNotAuthenticated()
    {
        $authenticationService = $this->prophesize(AuthenticationService::class);
        $authenticationService->getIdentity()->willReturn(null);

        $provider = new ZfcUserProvider($authenticationService->reveal());
        $this->setExpectedException(
            RuntimeException::class,
            sprintf('%s can not extract identifier if user is not authenticated', ZfcUserProvider::class)
        );
        $provider->getIdentifier();
    }
}