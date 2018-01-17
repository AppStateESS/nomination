<?php

namespace nomination\view;

use \nomination\view\NotificationView;
use \nomination\NominationModFactory;

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../config/core/404.html';
    exit();
}

\PHPWS_Core::requireInc('nomination', 'defines.php');
\PHPWS_Core::initModClass('notification', 'NQ.php');


$nv = new NotificationView();
$nv->popNotifications();
\Layout::add($nv->show());

$controller = NominationModFactory::getNomination();
$controller->process();
