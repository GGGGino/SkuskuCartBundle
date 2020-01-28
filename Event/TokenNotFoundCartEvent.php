<?php

namespace GGGGino\SkuskuCartBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TokenNotFoundCartEvent
 * @package GGGGino\SkuskuCartBundle\Event
 */
class TokenNotFoundCartEvent extends Event
{
    protected $response;   

    /**
     * @param string $test
     */
    public function __construct()
    {

    }

    public function setResponse($response)
    {
        $this->response = $response;
    }    

    public function getResponse()
    {
        return $this->response;
    }    

}
