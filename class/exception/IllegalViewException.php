<?php

PHPWS_Core::initModClass('nomination', 'exception/AccessException.php');

class IllegalViewException extends AccessException {
    
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}

?>