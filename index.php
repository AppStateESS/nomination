<?php

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../config/core/404.html';
    exit();
}

PHPWS_Core::requireInc('nomination', 'defines.php');
PHPWS_Core::initModClass('notification', 'NQ.php');

$controller = nomination\NominationModFactory::getNomination();
$controller->process();
