<?php
namespace nomination\view;

use \nomination\Context;
use \nomination\UserStatus;

class AdminMainMenu extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'AdminMainMenu');
    }

    public function display(Context $context)
    {
        if(!\Current_User::isLogged()){
            // If user is not logged in, redirect them to the login URL
            $auth = \Current_User::getAuthorization();
            \PHPWS_Core::reroute($auth->login_link);
        } else if(!UserStatus::isAdmin()) {
            // User is logged in, but does not have admin permissions
            throw new \nomination\exception\PermissionException('You are not allowed to see that!');
        }

        \PHPWS_Core::initModClass('nomination', 'Period.php');
        $vFactory = new \nomination\ViewFactory();

        $topMenu = $vFactory->get('NominationMainMenu');

        /** Search menu **/
        // (menu_title, tag)
        $topMenu->addMenu('Search', 'search');
        // (view_class, item_title, tag, parent_tag)
        $topMenu->addMenuItemByname('NomineeSearch', 'Nominees',
                                    'nominee_search', 'search');
        $topMenu->addMenuItemByname('NominatorSearch', 'Nominators',
                                    'nominator_search', 'search');

        /** Period **/
        $topMenu->addMenu('Period', 'period');
        $topMenu->addMenuItemByName('WinnersView', 'Winners',
                                    'award_winners', 'period');
        $topMenu->addMenuItemByName('PeriodMaintenance', 'Period Settings',
                                    'period_maintenance', 'period');
        $topMenu->addMenuItemByName('RolloverView', 'Rollover',
                                    'rollover_period', 'period');



        /** Forms **/
        $topMenu->addMenu('User Forms', 'forms');
        $topMenu->addMenuItemByName('NominationForm', 'Nomination Form',
                                    'nomination_form', 'forms');

        /** Administration **/
        $topMenu->addMenu('Administration', 'administration');
        $topMenu->addMenuItemByName('AdminSettings', 'Settings',
                                    'admin_settings', 'administration');
        $topMenu->addMenuItemByName('SendEmail', 'Send Email',
                                    'send_email', 'administration');
        $topMenu->addMenuItemByName('EmailLogView', 'Email Log',
                                    'view_log', 'administration');
        $topMenu->addMenuItemByName('CancelQueuePager', 'Removal Requests',
                                    'nom_removal', 'administration');

        \Layout::addPageTitle('Admin Main Menu');

        return $topMenu->show();
    }
}
