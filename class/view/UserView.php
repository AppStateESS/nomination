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
class UserView extends \nomination\View
{
    private $sideMenu;
    private $main;

    public function setMain($content){
        $this->main = $content;
    }

    public function getMain()
    {
        return $this->main;
    }

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
        \Layout::addStyle('nomination', 'css/nomination.css');
        return \PHPWS_Template::process($tpl, 'nomination', 'user.tpl');
    }
}
