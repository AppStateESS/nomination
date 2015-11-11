<?php
namespace nomination\view;

use \nomination\UserStatus;
use \nomination\Context;

/**
 * AdminMenu
 *
 * Side menu for administrators
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 * @package nomination
 */
class AdminMenu extends \nomination\ViewMenu
{
    public function __construct()
    {
        if(!UserStatus::isAdmin()){
            throw new \nomination\exception\PermissionException('You do not have permission to look at this!');
        }
        $this->addViewByName('Main Menu', 'AdminMainMenu');
        $this->addViewByName('Nominees', 'NomineeSearch');
        $this->addViewByName('Nominators', 'NominatorSearch');
        $this->addViewByName('Settings', 'AdminSettings');
        $this->addLink('Control Panel', 'index.php?module=controlpanel');
    }

    public function getRequestVars()
    {
        return array('view' => 'AdminMenu');
    }

    public function display(Context $context)
    {
        return parent::display($context);
    }
}
