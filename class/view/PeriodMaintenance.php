<?php

/**
 * Period Maintenance
 *
 * View for period settings
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 * @author Jeremy Booker
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'CommandFactory.php');
PHPWS_Core::initModClass('nomination', 'Period.php');

class PeriodMaintenance extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'PeriodMaintenance');
    }

    public function display(Context $context)
    {
        javascript('jquery');
        javascript('jquery_ui');
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to see that!');
        }
        $tpl = array();

        $form = new PHPWS_Form('period_');

        $cmdFactory = new CommandFactory();
        $updateCmd = $cmdFactory->get('UpdatePeriod');

        $updateCmd->initForm($form);

        // Begin and end dates for nomination period
        // Make dates readable by user
        $period = Period::getCurrentPeriod();

        $form->addText('nomination_period_start');
        $form->setLabel('nomination_period_start', 'Period Start Date');
        $form->addText('nomination_period_end');
        $form->setLabel('nomination_period_end', 'Period End Date');

        if(is_null($period)){
            // This can happen if no periods are configured yet (e.g. on first install)
            $tpl['CURRENT_PERIOD_YEAR'] = '<span class="error-text">No period set</span>';
        } else {
            $start = $period->getReadableStartDate();
            $end = $period->getReadableEndDate();

            // Pre-populate existing values for start-end dates
            $form->setValue('nomination_period_start', $start);
            $form->setValue('nomination_period_end', $end);

            // Display period information
            //$currYear = PHPWS_Settings::get('nomination', 'current_period');
            $tpl['CURRENT_PERIOD_YEAR'] = $period->getYear();

            // Link to rollover view
            $vFactory = new ViewFactory();
            $rolloverView = $vFactory->get('RolloverView');
            $tpl['NEXT_PERIOD'] = $period->getNextPeriodYear();
            $tpl['ROLLOVER_LINK'] = '[' . $rolloverView->getLink('Rollover') . ']';
        }

        $form->addText('rollover_email', PHPWS_Settings::get('nomination', 'rollover_email'));
        $form->setLabel('rollover_email', 'Rollover Reminder');

        // For use with JQuery datepicker and start/end dates
        $tpl['START_DATE_ID'] = $form->getFormId().'_nomination_period_start';
        $tpl['END_DATE_ID'] = $form->getFormId().'_nomination_period_end';

        $tpl['HELP_ICON'] = PHPWS_SOURCE_HTTP."mod/nomination/img/tango/apps/help-browser.png";

        $form->addSubmit('Update Period');

        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        Layout::addPageTitle('Period Settings');

        return PHPWS_Template::process($tpl, 'nomination', 'admin/period_maintenance.tpl');
    }
}

?>
