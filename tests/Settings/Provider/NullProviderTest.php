<?php

namespace Svycka\SettingsTest\Provider;

use Svycka\Settings\Provider\NullProvider;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class NullProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetIdentifier()
    {
        $provider = new NullProvider();
        $this->assertNull($provider->getIdentifier());
    }
}
