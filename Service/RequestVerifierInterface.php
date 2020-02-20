<?php

namespace GGGGino\SkuskuCartBundle\Service;

use Payum\Core\Security\TokenInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestVerifierInterface
 * @package GGGGino\SkuskuCartBundle\Service
 */
interface RequestVerifierInterface
{
    /**
     * Execute the verify
     *
     * @param Request $request
     * @param mixed $extra
     * @return TokenInterface
     */
    public function verify(Request $request, $extra = null);

    /**
     * Check if the verifier is enabled to execute the verify
     *
     * @param Request $request
     * @return boolean
     */
    public function supports(Request $request);
}