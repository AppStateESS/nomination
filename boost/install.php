<?php

function nomination_install(&$content)
{
    $today = getdate();
    $thisYear = $today['year'];
    
    // Create period
    PHPWS_Core::initModClass('nomination', 'Period.php');
    $period = new Period();
    
    $period->year = $thisYear;

    $period->setDefaultStartDate();
    $period->setDefaultEndDate();
    $period->save();

    // Create pulse for this period
    PHPWS_Core::initModClass('nomination', 'NominationRolloverEmailPulse.php');
    $pulse = new NominationRolloverEmailPulse();
    $timeDiff = $period->getEndDate() - time();
    $pulse->newFromNow($timeDiff);

    // Create Committee group
    PHPWS_Core::initModClass('users', 'Group.php');
    $group = new PHPWS_Group();
    $group->setName('nomination_committee');
    $group->setActive(True);
    $group->save();
    
    return true;
}

?>
