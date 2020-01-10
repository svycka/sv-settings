<?php

namespace Svycka\SettingsTest\Provider;

use Svycka\Settings\Provider\NullProvider;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class NullProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testCanGetIdentifier()
    {
        $provider = new NullProvider();
        $this->assertNull($provider->getIdentifier());
    }
}
