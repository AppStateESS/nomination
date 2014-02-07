<?php

PHPWS_Core::initModClass('nomination', 'exception/CommandException.php');

class CommandNotFoundException extends CommandException {
    
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}

?>