<?php

namespace Svycka\Settings\Provider;

use Svycka\Settings\Exception\RuntimeException;
use Zend\Authentication\AuthenticationService;

/**
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class ZfcUserProvider implements OwnerProviderInterface
{
    /** @var AuthenticationService */
    protected $authenticationService;

    /**
     * ZfcUserProvider constructor
     *
     * @param AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        /** @var \ZfcUser\Entity\UserInterface $identity */
        $identity = $this->authenticationService->getIdentity();

        if (!$identity) {
            throw new RuntimeException(__CLASS__ .' can not extract identifier if user is not authenticated');
        }

        return $identity->getId();
    }
}