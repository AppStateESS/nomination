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

if(NOMINATION_DEBUG){
    $controller = NominationModFactory::getNomination();
    $controller->process();
} else {
    try {
        $controller = NominationModFactory::getNomination();
        $controller->process();
    } catch(\Exception $e) {
        /*try {
            $message = $this->formatException($e);
            \NQ::Simple('hms', nomination\NotificationView::ERROR, 'An internal error has occurred, and the authorities have been notified.  We apologize for the inconvenience.');
            $this->emailError($message);
            $nv = new nomination\NotificationView();
            $nv->popNotifications();
            \Layout::add($nv->show());
        } catch(Exception $e) {
            $message2 = $this->formatException($e);
            echo "Nomination has experienced a major internal error.  Attempting to email an admin and then exit.";
            $message = "Something terrible has happened, and the exception catch-all threw an exception.\n\nThe first exception was:\n\n$message\n\nThe second exception was:\n\n$message2";
            mail('ess@appstate.edu', 'A Major HMS Error Has Occurred', $message);
            exit();
        }*/
    }
}
