<?php

namespace Svycka\SettingsTest\Provider\Factory;

use Svycka\Settings\Provider\Factory\ZfcUserProviderFactory;
use Svycka\Settings\Provider\ZfcUserProvider;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ZfcUserProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreate()
    {
        $serviceManager = $this->prophesize(ServiceLocatorInterface::class);
        $serviceManager->get('zfcuser_auth_service')->willReturn($this->getMock(AuthenticationService::class));

        $factory = new ZfcUserProviderFactory();
        $provider = $factory->createService($serviceManager->reveal());
        $this->assertInstanceOf(ZfcUserProvider::class, $provider);
    }
}
