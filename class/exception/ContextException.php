<?php
namespace nomination\exception;

class ContextException extends NominationException
{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}
