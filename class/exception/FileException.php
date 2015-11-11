<?php
namespace nomination\exception;

class FileException extends NominationException
{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}
