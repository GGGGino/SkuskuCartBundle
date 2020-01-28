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
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }    

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }    

}
