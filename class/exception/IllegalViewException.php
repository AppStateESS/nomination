<?php
namespace nomination\exception;

class IllegalViewException extends AccessException {

    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}
