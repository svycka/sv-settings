<?php

namespace Svycka\Settings\Provider;

/**
 * Class NullProvider
 *
 * This provider could be used for global settings when owner is not relevant
 *
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class NullProvider implements OwnerProviderInterface
{
    /**
     * @return null
     */
    public function getIdentifier()
    {
        return null;
    }
}
