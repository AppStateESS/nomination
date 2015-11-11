<?php
namespace nomination\exception;

class IllegalFileException extends FileException
{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}
