<?php
namespace nomination\view;

/**
* NotificationView
*
*   Handles rendering NQ messages for this application.
*
* @author Daniel West <dwest at tux dot appstate dot edu>
* @inspired-by Jeff Tickle's NotificationView in hms
* @package nomination
*/
class NotificationView
{
    const NOMINATION_SUCCESS    = 0;
    const NOMINATION_ERROR      = 1;
    const NOMINATION_WARNING    = 2;


    private $notifications = array();

    public function popNotifications()
    {
        $this->notifications = \NQ::popAll('nomination');
    }

    public static function immediateError($message)
    {
        \NQ::simple('nomination', self::NOMINATION_ERROR, $message);
        \NQ::close();

        exit();
    }

    public function show()
    {
        if(empty($this->notifications)) {
            return '';
        }

        $tpl = array();
        $tpl['NOTIFICATIONS'] = array();

        foreach($this->notifications as $notification) {
            if(!$notification instanceof \Notification) {
                throw new \InvalidArgumentException('Something was pushed onto the NQ that was not a Notification.');
            }

            $type = self::resolveType($notification);
            $tpl['NOTIFICATIONS'][][$type] = $notification->toString();
        }

        $content = \PHPWS_Template::process($tpl, 'nomination', 'NotificationView.tpl');

        javascript('jquery');

        return $content;
    }

    public function resolveType(\Notification $notification)
    {
        switch($notification->getType()) {
            case self::NOMINATION_SUCCESS:
            return 'SUCCESS';
            case self::NOMINATION_ERROR:
            return 'ERROR';
            case self::NOMINATION_WARNING:
            return 'WARNING';
            default:
            return 'UNKNOWN';
        }
    }
}
