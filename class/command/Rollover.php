<?php

  /**
   * Rollover
   *
   * Change current period to new period.  Delete all
   * non-winning nominations.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'Command.php');

class Rollover extends Command
{

    public function getRequestVars()
    {
        return array('action' => 'Rollover', 'after' => 'PeriodMaintenance');
    }

    public function execute(Context $context)
    {
        if(!UserStatus::isAdmin() || !Current_User::allow('nomination', 'rollover_period')){
            throw new PermissionException('You are not allowed to do this!');
        }

        PHPWS_Core::initModClass('nomination', 'Nomination.php');
        PHPWS_Core::initModClass('nomination', 'NominationEmail.php');
        PHPWS_Core::initModClass('nomination', 'Period.php');
        PHPWS_Core::initModClass('nomination', 'EmailMessage.php');


        // Check for errors when deleting
        foreach($results as $actor=>$result){
            if(in_array(False, $result)){
                PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
                throw new DatabaseException('Error occured deleting '.$actor. ' for nomination ');
            }
        }

        // Change period
        $newYear = Period::getNextPeriodYear();

        $newPeriod = new Period();
        $newPeriod->setYear($newYear);
        $newPeriod->setDefaultStartDate();
        $newPeriod->setDefaultEndDate();
        $newPeriod->save();

        PHPWS_Settings::set('nomination', 'current_period', $newYear);
        PHPWS_Settings::save('nomination');

        // Add new pulse
        PHPWS_Core::initModClass('nomination', 'NominationRolloverEmailPulse.php');
        $pulse = new NominationRolloverEmailPulse();
        $timeDiff = mktime() - $newPeriod->getEndDate();
        $pulse->newFromNow($timeDiff);


        NQ::simple('nomination', NOMINATION_SUCCESS, 'Current period is now '.$newYear);
    }
}

?>
