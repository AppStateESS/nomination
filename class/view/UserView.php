<?php
namespace nomination\view;

use \nomination\Context;
use \nomination\UserStatus;

/**
 * UserView
 *
 * This is a container view used by everyone (Guests, Committee, Admins,...)
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 * @package nomination;
 */
class UserView extends \nomination\NomView
{
    private $sideMenu;

    public function getRequestVars(){
        return array('view'=>'UserView');
    }

    public function addSideMenu($content)
    {
        $this->sideMenu = $content;
    }

    public function display(Context $context)
    {
        $tpl = array();

        $tpl['NOTIFICATION'] = $context['nq'];

        $tpl['MAIN'] = $this->getMain();
        $tpl['MENU'] = $this->sideMenu;
        $tpl['USER_STATUS'] = UserStatus::getDisplay();
        return $this->displayNomination(\PHPWS_Template::process($tpl, 'nomination', 'user.tpl'));
    }
}
