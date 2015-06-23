<?php

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../config/core/404.html';
    exit();
}

PHPWS_Core::requireInc('nomination', 'defines.php');
PHPWS_Core::initModClass('nomination', 'Context.php');

PHPWS_Core::initModClass('notification', 'NQ.php');
PHPWS_Core::initModClass('nomination', 'view/NominationNotificationView.php');

PHPWS_Core::initModClass('nomination', 'NominationModFactory.php');

$controller = NominationModFactory::getNomination();
$controller->process();

?>