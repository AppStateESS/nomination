<?php
namespace nomination\exception;

class FileNotFoundException extends FileException
{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}
