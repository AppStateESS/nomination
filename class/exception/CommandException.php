<?php

PHPWS_Core::initModClass('nomination', 'exception/NominationException.php');

class CommandException extends NominationException {
    
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}

?>