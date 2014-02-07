<?php

PHPWS_Core::initModClass('nomination', 'exception/NominationException.php');

class InvalidSettingsException extends NominationException
{
    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }
}