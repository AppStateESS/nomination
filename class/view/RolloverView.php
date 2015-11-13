<?php
namespace nomination\view;

use \nomination\Context;
use \nomination\CommandFactory;
use \nomination\Period;
use \nomination\UserStatus;

  /**
   * RolloverView
   *
   * Show information about rollover with button to perform rollover.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */
class RolloverView extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'RolloverView');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin() && Current_User::allow('nomination', 'rollover_period')){
            throw new PermissionException('You are not allowed to see that!');
        }

        $form = new \PHPWS_Form('rollover');

        // Get submit command
        $cmdFactory = new CommandFactory();
        $rolloverCmd = $cmdFactory->get('Rollover');
        $rolloverCmd->initForm($form);

        $tpl = array();

        $period = Period::getCurrentPeriod();
        $tpl['CURRENT_PERIOD'] = $period->getYear();
        $tpl['NEXT_PERIOD'] = $period->getNextPeriodYear();

        $form->addSubmit('submit', 'Perform Rollover');

        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        \Layout::addPageTitle('Rollover');

        return \PHPWS_Template::process($tpl, 'nomination', 'admin/rollover.tpl');
    }
}
