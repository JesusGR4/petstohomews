<?php
namespace App\Exceptions;


class Pets2HomeException extends \Exception
{
    public function __construct($message, $code = 500, \Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }
}