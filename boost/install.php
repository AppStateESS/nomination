<?php

function nomination_install(&$content)
{
    // Create pulse for this period

/*
    $pulse = \pulse\PulseFactory::getByName('RolloverEmailPulse', 'nomination');
    if (empty($pulse)) {
        $ps = pulse\PulseFactory::build();
        $ps->setName('RolloverEmailPulse');
        $ps->setModule('nomination');
        $ps->setClassName('NominationRolloverEmailPulse');
        $ps->setClassMethod('execute');
        $ps->setInterim('1');
        $ps->setRequiredFile('mod/nomination/class/NomincationRolloverEmailPulse.php');
        $ps->setExecuteAfter($period->start_date);
        pulse\PulseFactory::save($ps);
    }
*/


    // Create Committee group
    PHPWS_Core::initModClass('users', 'Group.php');
    $group = new PHPWS_Group();
    $group->setName('nomination_committee');
    $group->setActive(True);
    $group->save();

    return true;
}
