<?php

namespace GGGGino\SkuskuCartBundle\Exception;

class CurrencyNotFoundException extends \Exception
{
    /**
     * CurrencyNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        if( !empty($message) )
            $message = ": " . $message;

        $finalMessage = sprintf("Currency not found, maybe the db table is empty%s", $message);
        parent::__construct($finalMessage, $code, $previous);
    }
}