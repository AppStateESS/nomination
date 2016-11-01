<?php
namespace nomination\command;

use \nomination\Command;
use \nomination\UserStatus;
use \nomination\Context;
use \nomination\Nomination;
use \nomination\NominationEmail;
use \nomination\Period;
use \nomination\EmailMessage;
//use \nomination\NominationRolloverEmailPulse;

  /**
   * Rollover
   *
   * Change current period to new period.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */
class Rollover extends Command
{

    public function getRequestVars()
    {
        return array('action' => 'Rollover', 'after' => 'PeriodMaintenance');
    }

    public function execute(Context $context)
    {
        if(!UserStatus::isAdmin() || !\Current_User::allow('nomination', 'rollover_period')){
            throw new PermissionException('You are not allowed to do this!');
        }

        // Change period
        $newYear = Period::getNextPeriodYear();

        $newPeriod = new Period();
        $newPeriod->setYear($newYear);
        $newPeriod->setDefaultStartDate();
        $newPeriod->setDefaultEndDate();
        $newPeriod->save();

        \PHPWS_Settings::set('nomination', 'current_period', $newYear);
        \PHPWS_Settings::save('nomination');

        // Add new pulse
        /*
        $pulse = new NominationRolloverEmailPulse();
        $timeDiff = mktime() - $newPeriod->getEndDate();
        $pulse->newFromNow($timeDiff);
        */

        \NQ::simple('nomination', NotificationView::NOMINATION_SUCCESS, 'Current period is now '.$newYear);
    }
}
